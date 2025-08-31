<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
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
        $ticket = Ticket::findOrFail($ticket_id);
        $product = Product::first();

        return view('order.create', compact('product', 'ticket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_handphone' => 'required|string|max:20|regex:/^08\d{8,12}$/',
            'alamat_lengkap' => 'required|string|min:5|max:255',
            'identitas_number' => 'required|string|regex:/^\d{12,20}$/',
            'mewakili' => 'required|string|min:3|max:255',
        ], [
            'no_handphone.regex' => 'Nomor handphone harus dimulai dengan 08 dan berjumlah 10-14 digit',
            'identitas_number.regex' => 'Nomor identitas harus berupa angka 12-20 digit',
            'alamat_lengkap.min' => 'Alamat lengkap minimal 5 karakter',
            'mewakili.min' => 'Field mewakili minimal 3 karakter'
        ]);

        $ticket = Ticket::find($request->ticket_id);

        $quantity = 1;

        // Cek stok tiket
        if ($ticket->qty < $quantity) {
            return redirect()->back()
                ->with('error', 'Stok tiket tidak mencukupi. Stok tersedia: ' . $ticket->qty)
                ->withInput();
        }

        // // Hitung biaya berdasarkan quantity
        $ticket_price = $ticket->price * $quantity;

        // Generate payment code 3 digit random yang unik
        $payment_code = $this->generateUniquePaymentCode();

        $total_amount = $ticket_price + $payment_code;

        // Generate external ID yang unik
        do {
            $randomNumber = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $externalId = 'ORDER-' . $randomNumber;

            // Cek apakah external_id sudah ada di database
            $exists = Buyer::where('external_id', $externalId)->exists();
        } while ($exists);

        // Gunakan Database Transaction untuk memastikan atomicity
        DB::beginTransaction();

        try {
            // Kurangi stok tiket
            $ticket->decrement('qty', $quantity);

            // Simpan ke database buyers
            $buyer = new Buyer();
            $buyer->nama_lengkap = $request->nama_lengkap;
            $buyer->email = $request->email;
            $buyer->no_handphone = $request->no_handphone;
            $buyer->alamat_lengkap = $request->alamat_lengkap;
            $buyer->identitas_number = $request->identitas_number;
            $buyer->mewakili = $request->mewakili;
            $buyer->quantity = $quantity;
            $buyer->ticket_id = $request->ticket_id;
            $buyer->ticket_price = $ticket_price;
            // $buyer->admin_fee = $admin_fee;
            $buyer->payment_code = $payment_code;
            $buyer->total_amount = $total_amount;
            $buyer->external_id = $externalId;
            $buyer->payment_status = 'pending';
            $buyer->save();

            // Kirim email konfirmasi
            try {
                Mail::to($buyer->email)->send(new OrderConfirmation($buyer, $ticket));
                Log::info('Order confirmation email sent successfully', [
                    'external_id' => $externalId,
                    'email' => $buyer->email
                ]);
            } catch (Exception $emailException) {

                Log::error('Failed to send order confirmation email', [
                    'external_id' => $externalId,
                    'email' => $buyer->email,
                    'error' => $emailException->getMessage()
                ]);
            }

            // Commit transaction
            DB::commit();

            // Redirect ke halaman pembayaran manual
            return redirect()->route('payment.manual', ['external_id' => $externalId])
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
        } catch (Exception $e) {
            // Rollback transaction jika ada error
            DB::rollback();

            Log::error('Order Creation Failed', [
                'error_message' => $e->getMessage(),
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $ticket->id,
                'customer_email' => $request->email,
                'stack_trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('order.create', ['ticket_id' => $ticket->id])
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Generate unique payment code 3 digit
     */
    private function generateUniquePaymentCode()
    {
        do {
            // Generate random 3 digit number (100-999)
            $payment_code = rand(100, 999);

            // Cek apakah payment code sudah ada di database
            $exists = Buyer::where('payment_code', $payment_code)->exists();
        } while ($exists);

        return $payment_code;
    }

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
