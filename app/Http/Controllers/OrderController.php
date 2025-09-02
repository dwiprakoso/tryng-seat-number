<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Seat;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
use App\Models\BookingSeat;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

            // Cek stok tiket
            if ($ticket->qty <= 0) {
                return redirect()->back()->with('error', 'Tiket sudah habis.');
            }

            // Get seats berdasarkan ticket_id dengan pengurutan numerik
            $allSeats = Seat::where('ticket_id', $ticket_id)
                ->orderByRaw('CAST(seat_number AS UNSIGNED) ASC')
                ->get();
            // Check if there are available seats for this ticket
            $availableSeatsCount = $allSeats->where('is_booked', 0)->count();
            if ($availableSeatsCount == 0) {
                return redirect()->route('order.index')->with('seats_full', true);
            }

            return view('order.create', compact('product', 'ticket', 'allSeats'));
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
            'selected_seat' => 'required|exists:seats,seat_number',
            'nama_lengkap' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'no_handphone' => 'required|string|max:20|regex:/^08\d{8,12}$/',
        ], [
            'selected_seat.required' => 'Silakan pilih kursi terlebih dahulu',
            'selected_seat.exists' => 'Kursi yang dipilih tidak valid',
            'nama_lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'no_handphone.regex' => 'Nomor handphone harus dimulai dengan 08 dan berjumlah 10-14 digit',
        ]);

        // Pre-generate IDs untuk optimasi
        $paymentCode = $this->generateUniquePaymentCode();
        $externalId = $this->generateUniqueExternalId();

        DB::beginTransaction();

        try {
            // 1. Cek dan update seat dalam satu query optimized
            $seatUpdated = DB::table('seats')
                ->where('seat_number', $request->selected_seat)
                ->where('is_booked', 0)
                ->update(['is_booked' => 1]);

            if (!$seatUpdated) {
                throw new Exception('Kursi yang dipilih sudah tidak tersedia.');
            }

            // 2. Ambil seat ID setelah update
            $seat = Seat::where('seat_number', $request->selected_seat)->first();

            // 3. Ambil ticket dengan lock minimal
            $ticket = Ticket::lockForUpdate()->find($request->ticket_id);

            if (!$ticket || $ticket->qty < 1) {
                throw new Exception('Stok tiket tidak mencukupi.');
            }

            // 4. Cek duplikasi email dengan query optimized
            $existingOrder = DB::table('buyers')
                ->where('email', $request->email)
                ->where('ticket_id', $request->ticket_id)
                ->whereIn('payment_status', ['pending', 'paid'])
                ->exists();

            if ($existingOrder) {
                throw new Exception('Email ini sudah pernah digunakan untuk memesan tiket yang sama.');
            }

            $quantity = 1;
            $ticketPrice = $ticket->price * $quantity;
            $totalAmount = $ticketPrice + $paymentCode;

            // 5. Bulk operations - kombinasi create dan update
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
                'payment_status' => 'pending',
            ]);

            // 6. Create booking seat
            BookingSeat::create([
                'buyer_id' => $buyer->id,
                'seat_id' => $seat->id,
            ]);

            // 7. Update ticket quantity
            $ticket->decrement('qty', $quantity);

            DB::commit();

            // Kirim email konfirmasi (tetap synchronous seperti sebelumnya)
            try {
                Mail::to($buyer->email)->send(new OrderConfirmation($buyer, $ticket));
                Log::info('Order confirmation email sent successfully', [
                    'external_id' => $externalId,
                    'email' => $buyer->email,
                    'seat_number' => $seat->seat_number
                ]);
            } catch (Exception $emailException) {
                Log::error('Failed to send order confirmation email', [
                    'external_id' => $externalId,
                    'email' => $buyer->email,
                    'error' => $emailException->getMessage()
                ]);
            }

            Log::info('Order created successfully', [
                'external_id' => $externalId,
                'buyer_id' => $buyer->id,
                'seat_number' => $seat->seat_number,
            ]);

            return redirect()->route('payment.manual', ['external_id' => $externalId])
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Order Creation Failed', [
                'error_message' => $e->getMessage(),
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $request->ticket_id,
                'selected_seat' => $request->selected_seat,
                'customer_email' => $request->email,
            ]);

            return redirect()->route('order.create', ['ticket_id' => $request->ticket_id])
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
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
     * Generate unique payment code 3 digit
     */
    // private function generateUniquePaymentCode()
    // {
    //     do {
    //         // Generate random 3 digit number (100-999)
    //         $payment_code = rand(100, 999);

    //         // Cek apakah payment code sudah ada di database
    //         $exists = Buyer::where('payment_code', $payment_code)->exists();
    //     } while ($exists);

    //     return $payment_code;
    // }

    /**
     * Halaman pembayaran manual
     */
    public function manualPayment($external_id)
    {
        $buyer = Buyer::where('external_id', $external_id)->firstOrFail();
        $ticket = Ticket::find($buyer->ticket_id);
        $product = Product::first();

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
