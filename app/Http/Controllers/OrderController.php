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
        // Ambil 1 produk terbaru (event)
        $product = Product::latest()->first();

        // Ambil semua tiket yang statusnya published
        $tickets = Ticket::where('status', 'published')->get();

        return view('order.index', compact('product', 'tickets'));
    }

    public function create($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        $product = Product::first(); // Ambil product pertama karena hanya ada 1

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

        // Get ticket data untuk harga
        $ticket = Ticket::find($request->ticket_id);

        // Set quantity default 1 karena tidak ada di form
        $quantity = 1;

        // Cek stok tiket
        if ($ticket->qty < $quantity) {
            return redirect()->back()
                ->with('error', 'Stok tiket tidak mencukupi. Stok tersedia: ' . $ticket->qty)
                ->withInput();
        }

        // // Hitung biaya berdasarkan quantity
        $ticket_price = $ticket->price * $quantity;
        // $admin_fee = $ticket_price * 0.05; // 5% dari total harga tiket

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
                // Log error email tapi jangan gagalkan transaksi
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
        // Debug: Log semua data request
        Log::info('Upload Payment Proof Request', [
            'external_id' => $external_id,
            'has_file' => $request->hasFile('payment_proof'),
            'all_files' => $request->allFiles(),
            'request_data' => $request->all()
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

        // Debug: Log buyer status
        Log::info('Buyer Status', [
            'buyer_id' => $buyer->id,
            'payment_status' => $buyer->payment_status,
            'existing_proof' => $buyer->payment_proof
        ]);

        // Cek status pembayaran
        if ($buyer->payment_status === 'waiting_confirmation') {
            Log::warning('Payment already waiting confirmation', ['buyer_id' => $buyer->id]);
            return redirect()->back()
                ->with('info', 'Bukti pembayaran sudah diupload sebelumnya dan sedang dalam proses verifikasi.');
        }

        if ($buyer->payment_status === 'confirmed') {
            Log::warning('Payment already confirmed', ['buyer_id' => $buyer->id]);
            return redirect()->back()
                ->with('info', 'Pembayaran sudah dikonfirmasi.');
        }

        try {
            // Debug: Cek file detail
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');

                Log::info('File Details', [
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError()
                ]);

                // Pastikan folder exists
                $uploadPath = 'payment_proofs';
                if (!Storage::disk('public')->exists($uploadPath)) {
                    Storage::disk('public')->makeDirectory($uploadPath);
                    Log::info('Created directory: ' . $uploadPath);
                }

                // Hapus file lama jika ada
                if ($buyer->payment_proof) {
                    // Jika payment_proof berupa URL lengkap, ambil hanya nama filenya
                    $oldFileName = basename($buyer->payment_proof);
                    $oldFilePath = $uploadPath . '/' . $oldFileName;

                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                        Log::info('Deleted old file: ' . $oldFilePath);
                    }

                    // Jika payment_proof sudah berupa path relatif
                    if (strpos($buyer->payment_proof, 'http') === false) {
                        if (Storage::disk('public')->exists($buyer->payment_proof)) {
                            Storage::disk('public')->delete($buyer->payment_proof);
                            Log::info('Deleted old file: ' . $buyer->payment_proof);
                        }
                    }
                }

                // Generate filename yang unik
                $fileName = 'payment_' . $external_id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Upload file
                $filePath = $file->storeAs($uploadPath, $fileName, 'public');

                // Debug: Cek apakah file benar-benar tersimpan
                if (Storage::disk('public')->exists($filePath)) {
                    Log::info('File uploaded successfully', [
                        'file_path' => $filePath,
                        'full_path' => Storage::disk('public')->path($filePath),
                        'url' => Storage::disk('public')->url($filePath)
                    ]);
                } else {
                    Log::error('File upload failed - file not found after upload', [
                        'expected_path' => $filePath
                    ]);
                    throw new Exception('File tidak berhasil disimpan');
                }

                // PERBAIKAN: Simpan hanya path relatif, bukan URL lengkap
                $updateResult = $buyer->update([
                    'payment_proof' => $filePath, // Simpan: "payment_proofs/payment_ORDER-123_1234567890.jpg"
                    'payment_status' => 'waiting_confirmation'
                ]);

                Log::info('Buyer Updated', [
                    'buyer_id' => $buyer->id,
                    'update_result' => $updateResult,
                    'new_payment_proof' => $buyer->fresh()->payment_proof,
                    'new_status' => $buyer->fresh()->payment_status
                ]);

                return redirect()->back()
                    ->with('success', 'Bukti pembayaran berhasil diupload. Pembayaran Anda akan segera diverifikasi.');
            } else {
                Log::error('No file found in request', [
                    'has_file' => $request->hasFile('payment_proof'),
                    'all_files' => $request->allFiles()
                ]);

                return redirect()->back()
                    ->with('error', 'Tidak ada file yang diupload.')
                    ->withInput();
            }
        } catch (Exception $e) {
            Log::error('Payment Proof Upload Failed', [
                'buyer_id' => $buyer->id,
                'external_id' => $external_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }
}
