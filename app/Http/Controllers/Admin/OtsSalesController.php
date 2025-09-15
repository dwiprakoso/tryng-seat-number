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
        // Validate input data
        $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:255',
            'no_handphone' => 'required|string|max:20|regex:/^08\d{8,12}$/',
            'email' => 'nullable|email|max:255',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1|max:50', // Add reasonable max limit
            // 'payment_method' => 'required|in:cash,cashless',
            'selected_seats' => 'required|json',
        ], [
            'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
            'no_handphone.regex' => 'Nomor handphone harus dimulai dengan 08 dan berjumlah 10-14 digit',
            'quantity.max' => 'Maksimal 50 tiket per transaksi',
            'selected_seats.required' => 'Silakan pilih kursi terlebih dahulu',
            'selected_seats.json' => 'Data kursi tidak valid',
        ]);

        // Parse and validate selected seats
        $selectedSeats = json_decode($request->selected_seats, true);
        $quantity = (int)$request->quantity;

        if (!is_array($selectedSeats) || count($selectedSeats) !== $quantity) {
            return redirect()->back()
                ->with('error', 'Jumlah kursi yang dipilih tidak sesuai dengan quantity tiket')
                ->withInput();
        }

        // Validate seat IDs are integers
        foreach ($selectedSeats as $seatId) {
            if (!is_numeric($seatId) || (int)$seatId <= 0) {
                return redirect()->back()
                    ->with('error', 'Data kursi tidak valid')
                    ->withInput();
            }
        }

        DB::beginTransaction();

        try {
            // 1. Lock and validate ticket
            $ticket = Ticket::lockForUpdate()->find($request->ticket_id);
            if (!$ticket) {
                throw new Exception('Tiket tidak ditemukan.');
            }

            // 2. Check ticket stock
            if ($ticket->qty < $quantity) {
                throw new Exception("Stok tiket tidak mencukupi. Tersedia: {$ticket->qty}, diminta: {$quantity}");
            }

            // 3. Lock and validate seats
            $seats = DB::table('seats')
                ->where('ticket_id', $request->ticket_id)
                ->whereIn('id', $selectedSeats) // Use seat IDs instead of seat_number
                ->lockForUpdate()
                ->get();

            // Validate all seats exist and belong to the ticket
            if ($seats->count() !== count($selectedSeats)) {
                $foundSeatIds = $seats->pluck('id')->toArray();
                $missingSeatIds = array_diff($selectedSeats, $foundSeatIds);
                throw new Exception('Kursi dengan ID: ' . implode(', ', $missingSeatIds) . ' tidak ditemukan atau tidak sesuai dengan tiket ini.');
            }

            // Check for already booked seats
            $bookedSeats = $seats->where('is_booked', 1);
            if ($bookedSeats->count() > 0) {
                $bookedSeatNumbers = $bookedSeats->pluck('seat_number')->toArray();
                throw new Exception('Kursi ' . implode(', ', $bookedSeatNumbers) . ' sudah dipesan orang lain.');
            }

            // 4. Calculate pricing (no admin fee since payment is cash)
            $ticketPrice = $ticket->price * $quantity;
            $adminFee = 0; // Always 0 for cash payment
            $totalAmount = $ticketPrice + $adminFee;

            // Generate unique external ID
            $externalId = $this->generateUniqueExternalId();

            // 5. Create buyer record with waiting_confirmation status
            $buyerData = [
                'nama_lengkap' => trim($request->nama_lengkap),
                'email' => $request->email ?: 'noemail@otssales.local',
                'no_handphone' => $request->no_handphone,
                'quantity' => $quantity,
                'ticket_id' => $request->ticket_id,
                'ticket_price' => $ticketPrice,
                'admin_fee' => $adminFee,
                'payment_code' => null,
                'total_amount' => $totalAmount,
                'external_id' => $externalId,
                'payment_status' => 'waiting_confirmation', // Changed from 'confirmed'
                'created_by_admin' => auth()->user()->id,
            ];

            // Generate QR code and verification URL
            try {
                $verifyUrl = url('/verify/' . $externalId);
                $qrCodePath = $this->generateAndSaveQrCode($verifyUrl, $externalId);
                $buyerData['qr_code'] = $qrCodePath;
            } catch (Exception $qrException) {
                Log::warning('QR Code generation failed, continuing without QR', [
                    'external_id' => $externalId,
                    'error' => $qrException->getMessage()
                ]);
                $buyerData['qr_code'] = null;
            }

            $buyer = Buyer::create($buyerData);

            // 6. Create booking seat records
            $bookingSeats = $seats->map(function ($seat) use ($buyer) {
                return [
                    'buyer_id' => $buyer->id,
                    'seat_id' => $seat->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            DB::table('booking_seat')->insert($bookingSeats);

            // 7. Update seat status to booked
            DB::table('seats')
                ->whereIn('id', $seats->pluck('id'))
                ->update(['is_booked' => 1, 'updated_at' => now()]);

            // 8. Decrement ticket quantity
            $ticket->decrement('qty', $quantity);

            DB::commit();

            // 9. Send email notification (optional) - only if email is provided
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
                        'email' => $request->email,
                        'error' => $emailException->getMessage()
                    ]);
                }
            }

            // Log successful transaction
            Log::info('OTS Sale created successfully', [
                'external_id' => $externalId,
                'buyer_id' => $buyer->id,
                'ticket_id' => $request->ticket_id,
                'seat_ids' => $selectedSeats,
                'seat_numbers' => $seats->pluck('seat_number')->toArray(),
                'quantity' => $quantity,
                'payment_method' => 'cash',
                'ticket_price' => $ticketPrice,
                'admin_fee' => $adminFee,
                'total_amount' => $totalAmount,
                'created_by' => auth()->user()->id,
            ]);

            return redirect()->route('admin.ots-sales.index')
                ->with('success', "Penjualan OTS untuk {$quantity} tiket berhasil dibuat dengan status menunggu konfirmasi. External ID: {$externalId}");
        } catch (Exception $e) {
            DB::rollback();

            // Cleanup QR code file if it was created
            if (isset($qrCodePath) && $qrCodePath && Storage::disk('public')->exists($qrCodePath)) {
                try {
                    Storage::disk('public')->delete($qrCodePath);
                } catch (Exception $cleanupException) {
                    Log::error('Failed to cleanup QR code file', [
                        'file_path' => $qrCodePath,
                        'error' => $cleanupException->getMessage()
                    ]);
                }
            }

            // Log error details
            Log::error('OTS Sale Creation Failed', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $request->ticket_id,
                'selected_seats' => $selectedSeats ?? [],
                'quantity' => $quantity,
                'admin_id' => auth()->user()->id,
                'request_data' => $request->except(['_token', '_method']),
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
