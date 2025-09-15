<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Seat;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\OtsSales;
use Endroid\QrCode\QrCode;
use App\Models\BookingSeat;
use Illuminate\Http\Request;
use App\Exports\OtsSalesExport;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class OtsSalesController extends Controller
{
    public function index()
    {
        $otsSales = Buyer::with(['ticket', 'seats', 'bookingSeats.seat'])
            ->orderBy('created_at', 'desc')
            ->get();

        $tickets = Ticket::where('status', 'scheduled')
            ->where('qty', '>', 0)
            ->with('seats')
            ->get();

        return view('admin.page.ots-sales.index', compact('otsSales', 'tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:255',
            'no_handphone' => 'required|string|max:20|regex:/^08\d{8,12}$/',
            'email' => 'nullable|email|max:255',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,cashless',
            'selected_seats' => 'required|json',
        ], [
            'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'no_handphone.regex' => 'Nomor handphone harus dimulai dengan 08 dan berjumlah 10-14 digit',
            'selected_seats.required' => 'Silakan pilih kursi terlebih dahulu',
            'selected_seats.json' => 'Data kursi tidak valid',
        ]);

        $selectedSeats = json_decode($request->selected_seats, true);

        if (!is_array($selectedSeats) || count($selectedSeats) !== (int)$request->quantity) {
            return redirect()->back()
                ->with('error', 'Jumlah kursi yang dipilih tidak sesuai dengan quantity tiket')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $quantity = (int)$request->quantity;

            // 1. Lock ticket untuk mencegah race condition
            $ticket = Ticket::lockForUpdate()->find($request->ticket_id);
            if (!$ticket) {
                throw new Exception('Tiket tidak ditemukan.');
            }

            // 2. Validasi stok tiket
            if ($ticket->qty < $quantity) {
                throw new Exception("Stok tiket tidak mencukupi. Tersedia: {$ticket->qty}, diminta: {$quantity}");
            }

            // 3. Lock dan validasi seats
            $seats = DB::table('seats')
                ->where('ticket_id', $request->ticket_id)
                ->whereIn('seat_number', $selectedSeats)
                ->lockForUpdate()
                ->get();

            // Validasi semua seat ada
            if ($seats->count() !== count($selectedSeats)) {
                throw new Exception('Beberapa kursi tidak ditemukan atau tidak sesuai dengan tiket ini.');
            }

            // Validasi tidak ada seat yang sudah booked
            $bookedSeats = $seats->where('is_booked', 1);
            if ($bookedSeats->count() > 0) {
                $bookedSeatNumbers = $bookedSeats->pluck('seat_number')->toArray();
                throw new Exception('Kursi ' . implode(', ', $bookedSeatNumbers) . ' sudah dipesan orang lain.');
            }

            // 4. Calculate amounts
            $ticketPrice = $ticket->price * $quantity;
            $adminFee = $request->payment_method === 'cashless' ? $ticketPrice * 0.05 : 0;
            $totalAmount = $ticketPrice + $adminFee;

            // Generate external ID
            $externalId = $this->generateUniqueExternalId();

            // Generate URL untuk verifikasi tiket
            $verifyUrl = url('/verify/' . $externalId);

            // Generate QR Code dan simpan sebagai file
            $qrCodePath = $this->generateAndSaveQrCode($verifyUrl, $externalId);

            // 5. Create buyer (OTS Sale)
            $buyer = Buyer::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email ?? 'noemail@otssales.local',
                'no_handphone' => $request->no_handphone,
                'quantity' => $quantity,
                'ticket_id' => $request->ticket_id,
                'ticket_price' => $ticketPrice,
                'admin_fee' => $adminFee,
                'payment_code' => null, // OTS sales tidak perlu payment code
                'total_amount' => $totalAmount,
                'external_id' => $externalId,
                'qr_code' => $qrCodePath,
                'payment_status' => 'confirmed', // Langsung confirmed untuk OTS
                'payment_method' => $request->payment_method,
                'created_by_admin' => auth()->user()->id, // Flag untuk OTS sales
            ]);

            // 6. Book the seats in booking_seat table
            $bookingSeats = [];
            foreach ($seats as $seat) {
                $bookingSeats[] = [
                    'buyer_id' => $buyer->id,
                    'seat_id' => $seat->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('booking_seat')->insert($bookingSeats);

            // 7. Update seat status
            DB::table('seats')
                ->whereIn('id', $seats->pluck('id'))
                ->update(['is_booked' => 1]);

            // 8. Update ticket quantity
            $ticket->decrement('qty', $quantity);

            DB::commit();

            // 9. Send email if email provided (optional untuk OTS)
            if ($request->filled('email') && filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                try {
                    Mail::to($request->email)->send(new OrderConfirmation($buyer, $ticket));
                    Log::info('OTS Sale email sent successfully', [
                        'external_id' => $externalId,
                        'email' => $request->email,
                    ]);
                } catch (Exception $emailException) {
                    Log::error('Failed to send OTS sale email', [
                        'external_id' => $externalId,
                        'error' => $emailException->getMessage()
                    ]);
                }
            }

            Log::info('OTS Sale created successfully', [
                'external_id' => $externalId,
                'buyer_id' => $buyer->id,
                'seats' => $selectedSeats,
                'quantity' => $quantity,
                'payment_method' => $request->payment_method,
                'admin_fee' => $adminFee,
                'created_by' => auth()->user()->id,
            ]);

            return redirect()->route('admin.ots-sales.index')
                ->with('success', "Penjualan OTS untuk {$quantity} tiket berhasil dibuat. External ID: {$externalId}");
        } catch (Exception $e) {
            DB::rollback();

            // Cleanup QR code jika ada error
            if (isset($qrCodePath) && $qrCodePath && Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }

            Log::error('OTS Sale Creation Failed', [
                'error_message' => $e->getMessage(),
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $request->ticket_id,
                'selected_seats' => $selectedSeats ?? [],
                'quantity' => $request->quantity ?? 0,
                'admin_id' => auth()->user()->id,
            ]);

            return redirect()->back()
                ->with('error', 'Gagal membuat penjualan OTS: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Method helper yang sama seperti sebelumnya
    private function generateAndSaveQrCode($data, $externalId)
    {
        try {
            $qrCode = new QrCode($data);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $directory = 'qr-codes';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $fileName = $directory . '/qr_ots_' . $externalId . '_' . time() . '.png';
            $qrCodeData = $result->getString();

            if (empty($qrCodeData)) {
                throw new Exception('QR code data is empty');
            }

            $saved = Storage::disk('public')->put($fileName, $qrCodeData);

            if (!$saved) {
                throw new Exception('Gagal menyimpan QR code ke storage');
            }

            if (!Storage::disk('public')->exists($fileName)) {
                throw new Exception('QR code file tidak ditemukan setelah disimpan');
            }

            Log::info('OTS QR Code generated successfully', [
                'external_id' => $externalId,
                'file_path' => $fileName,
            ]);

            return $fileName;
        } catch (Exception $e) {
            Log::error('OTS QR Code generation failed', [
                'external_id' => $externalId,
                'error' => $e->getMessage(),
            ]);
            throw new Exception('Gagal generate QR code: ' . $e->getMessage());
        }
    }

    private function generateUniqueExternalId()
    {
        do {
            $randomNumber = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $externalId = 'OTS-' . now()->format('Ymd') . '-' . $randomNumber;

            $exists = Buyer::where('external_id', $externalId)->exists();
        } while ($exists);

        return $externalId;
    }

    public function receipt($id)
    {
        $otsSale = OtsSales::with('ticket')->findOrFail($id);

        return view('admin.page.ots-sales.receipt', compact('otsSale'));
    }

    public function destroy($id)
    {
        try {
            $otsSale = OtsSales::findOrFail($id);

            // Return ticket quantity
            $ticket = Ticket::findOrFail($otsSale->ticket_id);
            $ticket->increment('qty', $otsSale->quantity);

            $otsSale->delete();

            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            $fileName = 'ots-sales-' . date('Y-m-d-H-i-s') . '.xlsx';

            return Excel::download(new OtsSalesExport, $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat export data: ' . $e->getMessage());
        }
    }
}
