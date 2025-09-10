<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Seat;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
use Endroid\QrCode\QrCode;
use App\Models\BookingSeat;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Support\Facades\Log;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class OrderController extends Controller
{
    public function index()
    {
        $product = Product::latest()->first();
        $tickets = Ticket::where('status', 'published')->get();

        // $tickets = Ticket::where('status', 'published')->where('qty', '>', 0)->get();

        return view('order.index', compact('product', 'tickets'));
    }

    public function create($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $product = Product::first();

            // Cek stok tiket berdasarkan qty di tabel tickets
            if ($ticket->qty <= 0) {
                return redirect()->route('order.index')->with('error', 'Tiket sudah habis.');
            }

            // Get seats berdasarkan ticket_id dengan pengurutan numerik
            $allSeats = Seat::where('ticket_id', $ticket_id)
                ->orderByRaw('CAST(seat_number AS UNSIGNED) ASC')
                ->get();

            // Hitung seat yang tersedia (untuk display saja)
            $availableSeatsCount = $allSeats->where('is_booked', 0)->count();

            // Validasi konsistensi: seat tersedia tidak boleh lebih dari qty tiket
            if ($availableSeatsCount > $ticket->qty) {
                Log::warning('Inconsistency detected: Available seats more than ticket qty', [
                    'ticket_id' => $ticket_id,
                    'ticket_qty' => $ticket->qty,
                    'available_seats' => $availableSeatsCount
                ]);
            }

            // Gunakan nilai minimum antara qty tiket dan available seats sebagai stok aktual
            $actualAvailableStock = min($ticket->qty, $availableSeatsCount);

            if ($actualAvailableStock == 0) {
                return redirect()->route('order.index')->with('seats_full', true);
            }

            return view('order.create', compact(
                'product',
                'ticket',
                'allSeats',
                'availableSeatsCount',
                'actualAvailableStock'
            ));
        } catch (Exception $e) {
            Log::error('Error loading order form', [
                'ticket_id' => $ticket_id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat form pemesanan.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'selected_seats' => 'required|json',
            'quantity' => 'required|integer|min:1',
            'nama_lengkap' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'no_handphone' => 'required|string|max:20|regex:/^08\d{8,12}$/',
        ], [
            'selected_seats.required' => 'Silakan pilih kursi terlebih dahulu',
            'selected_seats.json' => 'Data kursi tidak valid',
            'quantity.min' => 'Jumlah tiket minimal 1',
            'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'no_handphone.regex' => 'Nomor handphone harus dimulai dengan 08 dan berjumlah 10-14 digit',
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

            // 1. Lock ticket terlebih dahulu untuk mencegah race condition
            $ticket = Ticket::lockForUpdate()->find($request->ticket_id);
            if (!$ticket) {
                throw new Exception('Tiket tidak ditemukan.');
            }

            // Cek apakah tiket gratis atau berbayar
            $isFreeTicket = $ticket->price == 0;

            // 2. Validasi stok tiket dari database
            if ($ticket->qty < $quantity) {
                throw new Exception("Stok tiket tidak mencukupi. Tersedia: {$ticket->qty}, diminta: {$quantity}");
            }

            // 3. Lock dan validasi seats secara atomic
            $seats = Seat::where('ticket_id', $request->ticket_id)
                ->whereIn('seat_number', $selectedSeats)
                ->lockForUpdate()
                ->get();

            // Validasi semua seat ada dan sesuai ticket_id
            if ($seats->count() !== count($selectedSeats)) {
                throw new Exception('Beberapa kursi tidak ditemukan atau tidak sesuai dengan tiket ini.');
            }

            // Validasi tidak ada seat yang sudah booked
            $bookedSeats = $seats->where('is_booked', 1);
            if ($bookedSeats->count() > 0) {
                $bookedSeatNumbers = $bookedSeats->pluck('seat_number')->toArray();
                throw new Exception('Kursi ' . implode(', ', $bookedSeatNumbers) . ' sudah dipesan orang lain.');
            }

            // 4. Validasi stok gabungan (minimum antara ticket qty dan available seats)
            $availableSeatsCount = Seat::where('ticket_id', $request->ticket_id)
                ->where('is_booked', 0)
                ->count();

            $actualAvailableStock = min($ticket->qty, $availableSeatsCount);

            if ($quantity > $actualAvailableStock) {
                throw new Exception("Stok tidak mencukupi. Stok aktual tersedia: {$actualAvailableStock} (tiket: {$ticket->qty}, seat: {$availableSeatsCount})");
            }

            $ticketPrice = $ticket->price * $quantity;

            if ($isFreeTicket) {
                $paymentCode = 0;
                $totalAmount = 0;
                $paymentStatus = 'waiting_confirmation';
            } else {
                $paymentCode = $this->generateUniquePaymentCode();
                $totalAmount = $ticketPrice + $paymentCode;
                $paymentStatus = 'pending';
            }

            $externalId = $this->generateUniqueExternalId();

            // Generate URL untuk verifikasi tiket
            $verifyUrl = url('/verify/' . $externalId);

            // Generate QR Code dan simpan sebagai file
            $qrCodePath = $this->generateAndSaveQrCode($verifyUrl, $externalId);

            $buyer = Buyer::create([
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_handphone' => $request->no_handphone,
                'quantity' => $quantity,
                'ticket_id' => $request->ticket_id,
                'ticket_price' => $ticketPrice,
                'payment_code' => $paymentCode,
                'total_amount' => $totalAmount,
                'external_id' => $externalId,
                'qr_code' => $qrCodePath,
                'payment_status' => $paymentStatus,
            ]);

            $bookingSeats = [];
            foreach ($seats as $seat) {
                $bookingSeats[] = [
                    'buyer_id' => $buyer->id,
                    'seat_id' => $seat->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            BookingSeat::insert($bookingSeats);

            Seat::whereIn('id', $seats->pluck('id'))
                ->update(['is_booked' => 1]);

            $ticket->decrement('qty', $quantity);

            DB::commit();

            try {
                Mail::to($buyer->email)->send(new OrderConfirmation($buyer, $ticket));
                Log::info('Order confirmation email sent successfully', [
                    'external_id' => $externalId,
                    'email' => $buyer->email,
                    'seats' => $selectedSeats,
                    'quantity' => $quantity,
                    'is_free_ticket' => $isFreeTicket
                ]);
            } catch (Exception $emailException) {
                Log::error('Failed to send order confirmation email', [
                    'external_id' => $externalId,
                    'email' => $buyer->email,
                    'error' => $emailException->getMessage()
                ]);
            }

            Log::info($isFreeTicket ? 'Free ticket order created successfully' : 'Multi-ticket order created successfully', [
                'external_id' => $externalId,
                'buyer_id' => $buyer->id,
                'seats' => $selectedSeats,
                'quantity' => $quantity,
                'ticket_stock_before' => $ticket->qty + $quantity,
                'ticket_stock_after' => $ticket->qty,
                'qr_code_path' => $qrCodePath,
                'is_free_ticket' => $isFreeTicket,
            ]);

            if ($isFreeTicket) {
                return redirect()->route('payment.manual', ['external_id' => $externalId])
                    ->with('success', "Pesanan untuk {$quantity} tiket gratis berhasil dibuat. Menunggu konfirmasi admin.");
            } else {
                return redirect()->route('payment.manual', ['external_id' => $externalId])
                    ->with('success', "Pesanan untuk {$quantity} tiket berhasil dibuat. Silakan lakukan pembayaran.");
            }
        } catch (Exception $e) {
            DB::rollback();

            if (isset($qrCodePath) && $qrCodePath && Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }

            Log::error('Order Creation Failed', [
                'error_message' => $e->getMessage(),
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $request->ticket_id,
                'selected_seats' => $selectedSeats ?? [],
                'quantity' => $request->quantity ?? 0,
                'customer_email' => $request->email,
            ]);

            return redirect()->route('order.create', ['ticket_id' => $request->ticket_id])
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Generate QR code menggunakan approach langsung untuk Endroid v6.0
     */
    private function generateAndSaveQrCode($data, $externalId)
    {
        try {
            // Metode langsung tanpa Builder (alternatif untuk v6.0)
            $qrCode = new QrCode($data);
            $writer = new PngWriter();

            // Generate hasil
            $result = $writer->write($qrCode);

            // Buat folder jika belum ada
            $directory = 'qr-codes';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Generate nama file unique dengan external_id
            $fileName = $directory . '/qr_' . $externalId . '_' . time() . '.png';

            // Get binary data dari QR code
            $qrCodeData = $result->getString();

            // Validasi data QR code
            if (empty($qrCodeData)) {
                throw new Exception('QR code data is empty');
            }

            // Simpan file ke storage
            $saved = Storage::disk('public')->put($fileName, $qrCodeData);

            if (!$saved) {
                throw new Exception('Gagal menyimpan QR code ke storage');
            }

            // Verifikasi file berhasil disimpan
            if (!Storage::disk('public')->exists($fileName)) {
                throw new Exception('QR code file tidak ditemukan setelah disimpan');
            }

            Log::info('QR Code generated and saved successfully (Direct method)', [
                'external_id' => $externalId,
                'file_path' => $fileName,
                'file_size' => strlen($qrCodeData),
                'storage_path' => storage_path('app/public/' . $fileName)
            ]);

            return $fileName; // Return relative path
        } catch (Exception $e) {
            Log::error('QR Code generation failed', [
                'external_id' => $externalId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Gagal generate QR code: ' . $e->getMessage());
        }
    }
    /**
     * Generate unique payment code (3 digit)
     */
    private function generateUniquePaymentCode()
    {
        do {
            $payment_code = rand(100, 999);
            // Cek duplikasi dalam 24 jam terakhir saja untuk performa
            $exists = Buyer::where('payment_code', $payment_code)
                ->where('created_at', '>=', now()->subDay())
                ->exists();
        } while ($exists);

        return $payment_code;
    }

    /**
     * Generate unique external ID dengan format yang lebih informatif
     */
    private function generateUniqueExternalId()
    {
        do {
            $randomNumber = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $externalId = 'ORDER-' . now()->format('Ymd') . '-' . $randomNumber;

            // Cek apakah external_id sudah ada di database
            $exists = Buyer::where('external_id', $externalId)->exists();
        } while ($exists);

        return $externalId;
    }

    /**
     * Halaman pembayaran manual
     */
    public function manualPayment($external_id)
    {
        $buyer = Buyer::where('external_id', $external_id)->firstOrFail();
        $ticket = Ticket::find($buyer->ticket_id);
        $product = Product::first();

        Log::info('Manual payment page accessed', [
            'external_id' => $external_id,
            'payment_status' => $buyer->payment_status,
            'total_amount' => $buyer->total_amount,
            'is_free_ticket' => $buyer->total_amount == 0
        ]);

        return view('payment.manual', compact('buyer', 'ticket', 'product'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadPaymentProof(Request $request, $external_id)
    {
        Log::info('Upload Payment Proof Request', [
            'external_id' => $external_id,
            'has_file' => $request->hasFile('payment_proof')
        ]);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diupload',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format file harus jpeg, png, atau jpg',
            'payment_proof.max' => 'Ukuran file maksimal 2MB'
        ]);

        $buyer = Buyer::where('external_id', $external_id)->firstOrFail();

        // Cek status pembayaran
        if (in_array($buyer->payment_status, ['waiting_confirmation', 'confirmed'])) {
            $message = $buyer->payment_status === 'confirmed'
                ? 'Pembayaran sudah dikonfirmasi.'
                : 'Bukti pembayaran sudah diupload sebelumnya dan sedang dalam proses verifikasi.';

            return redirect()->back()->with('info', $message);
        }

        try {
            $file = $request->file('payment_proof');
            $uploadPath = 'payment_proofs';

            // Hapus file lama jika ada
            if ($buyer->payment_proof && Storage::disk('public')->exists($buyer->payment_proof)) {
                Storage::disk('public')->delete($buyer->payment_proof);
            }

            // Upload file baru
            $fileName = 'payment_' . $external_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs($uploadPath, $fileName, 'public');

            // Update buyer
            $buyer->update([
                'payment_proof' => $filePath,
                'payment_status' => 'waiting_confirmation'
            ]);

            Log::info('Payment proof uploaded successfully', [
                'buyer_id' => $buyer->id,
                'file_path' => $filePath
            ]);

            return redirect()->back()
                ->with('success', 'Bukti pembayaran berhasil diupload. Pembayaran Anda akan segera diverifikasi.');
        } catch (Exception $e) {
            Log::error('Payment Proof Upload Failed', [
                'buyer_id' => $buyer->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }
}
