<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\XenditService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'no_handphone' => 'required|string|max:20',
            'quantity' => 'required|integer|min:1|max:5',
        ]);

        // Get ticket data untuk harga
        $ticket = Ticket::find($request->ticket_id);

        // Cek stok tiket
        if ($ticket->qty < $request->quantity) {
            return redirect()->back()
                ->with('error', 'Stok tiket tidak mencukupi. Stok tersedia: ' . $ticket->qty)
                ->withInput();
        }

        // Hitung biaya berdasarkan quantity
        $ticket_price = $ticket->price * $request->quantity;
        $admin_fee = $ticket_price * 0.05; // 5% dari total harga tiket
        $total_amount = $ticket_price + $admin_fee;

        // Generate external ID yang unik
        do {
            $randomNumber = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $externalId = 'SAMPOOKONG-' . $randomNumber;

            // Cek apakah external_id sudah ada di database
            $exists = Buyer::where('external_id', $externalId)->exists();
        } while ($exists);

        // Gunakan Database Transaction untuk memastikan atomicity
        DB::beginTransaction();

        try {
            // Kurangi stok tiket langsung (untuk testing)
            $ticket->decrement('qty', $request->quantity);

            // Simpan ke database buyers
            $buyer = new Buyer();
            $buyer->nama_lengkap = $request->nama_lengkap;
            $buyer->email = $request->email;
            $buyer->no_handphone = $request->no_handphone;
            $buyer->nama_instagram = '-'; // Default value
            $buyer->alamat_lengkap = '-'; // Default value
            $buyer->kode_pos = '-'; // Default value
            $buyer->ukuran_jersey = '-'; // Default value
            $buyer->quantity = $request->quantity;
            $buyer->ticket_id = $request->ticket_id;
            $buyer->ticket_price = $ticket_price;
            $buyer->admin_fee = $admin_fee;
            $buyer->total_amount = $total_amount;
            $buyer->external_id = $externalId;
            $buyer->save();

            // Debug: Cek konfigurasi Xendit
            $xenditKey = config('services.xendit.secret_key');
            if (!$xenditKey) {
                Log::error('Xendit API Key not configured');
                DB::rollback();
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Konfigurasi Xendit belum diatur. Silakan periksa file .env');
            }

            // Debug: Log data yang akan dikirim
            Log::info('Creating Xendit Invoice', [
                'buyer_id' => $buyer->id,
                'external_id' => $externalId,
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'ticket_price' => $ticket_price,
                'admin_fee' => $admin_fee,
                'total_amount' => $total_amount,
                'customer_name' => $request->nama_lengkap,
                'customer_email' => $request->email
            ]);

            $xenditService = new XenditService();

            $invoiceData = [
                'external_id' => $externalId,
                'description' => 'Pembelian Tiket: ' . $ticket->name . ' (' . $request->quantity . 'x)',
                'amount' => $total_amount,
                'success_url' => route('payment.success'),
                'failure_url' => route('payment.failed'),
                'items' => [
                    [
                        'name' => $ticket->name,
                        'quantity' => $request->quantity,
                        'price' => $ticket->price,
                        'category' => 'Tiket'
                    ],
                    [
                        'name' => 'Biaya Admin (5%)',
                        'quantity' => 1,
                        'price' => $admin_fee,
                        'category' => 'Admin Fee'
                    ]
                ],
                'customer' => [
                    'given_names' => $request->nama_lengkap,
                    'email' => $request->email,
                    'mobile_number' => $request->no_handphone,
                    'addresses' => [
                        [
                            'city' => 'Jakarta',
                            'country' => 'Indonesia',
                            'postal_code' => '10000',
                            'state' => 'DKI Jakarta',
                            'street_line1' => 'Jakarta',
                        ]
                    ]
                ]
            ];

            // Debug: Log invoice data sebelum dikirim
            Log::info('Invoice Data to be sent to Xendit', $invoiceData);

            $invoice = $xenditService->createInvoice($invoiceData);

            // Debug: Log response dari Xendit
            Log::info('Xendit Invoice Created Successfully', [
                'invoice_id' => $invoice['id'],
                'invoice_url' => $invoice['invoice_url']
            ]);

            // Update buyer dengan data invoice
            $buyer->update([
                'xendit_invoice_id' => $invoice['id'],
                'xendit_invoice_url' => $invoice['invoice_url'],
                'payment_status' => 'pending'
            ]);

            // Commit transaction
            DB::commit();

            // Redirect ke halaman invoice atau dashboard dengan link pembayaran
            return redirect($invoice['invoice_url']);
        } catch (Exception $e) {
            // Rollback transaction jika ada error
            DB::rollback();

            // Enhanced error logging
            Log::error('Xendit Invoice Creation Failed', [
                'error_message' => $e->getMessage(),
                'buyer_id' => $buyer->id ?? 'not_created',
                'external_id' => $externalId ?? 'not_generated',
                'ticket_id' => $ticket->id,
                'quantity' => $request->quantity,
                'customer_email' => $request->email ?? 'not_provided',
                'stack_trace' => $e->getTraceAsString()
            ]);

            // Return dengan error message yang lebih detail
            return redirect()->route('order.create')
                ->with('error', 'Gagal membuat invoice pembayaran: ' . $e->getMessage())
                ->with('debug_info', 'Silakan cek log untuk detail error');
        }
    }
}
