<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Buyer;
use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\XenditService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil 1 produk terbaru (event)
        $product = Product::latest()->first();

        // Ambil semua tiket
        $tickets = Ticket::all();

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
            'no_handphone' => 'required|string|max:20',
            'nama_instagram' => 'nullable|string|max:100',
            'alamat_lengkap' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'ukuran_jersey' => 'required|in:XS,S,M,L,XL,XXL,XXXL',
        ]);

        // Get ticket data untuk harga
        $ticket = Ticket::find($request->ticket_id);

        // Simpan ke database buyers
        $buyer = new Buyer();
        $buyer->nama_lengkap = $request->nama_lengkap;
        $buyer->no_handphone = $request->no_handphone;
        $buyer->nama_instagram = $request->nama_instagram;
        $buyer->alamat_lengkap = $request->alamat_lengkap;
        $buyer->kode_pos = $request->kode_pos;
        $buyer->ukuran_jersey = $request->ukuran_jersey;
        $buyer->ticket_id = $request->ticket_id;
        $buyer->total_amount = $ticket->price;
        $buyer->save();

        // Debug: Cek konfigurasi Xendit
        $xenditKey = config('services.xendit.secret_key');
        if (!$xenditKey) {
            Log::error('Xendit API Key not configured');
            return redirect()->route('admin.dashboard')
                ->with('error', 'Konfigurasi Xendit belum diatur. Silakan periksa file .env');
        }

        // Debug: Log data yang akan dikirim
        Log::info('Creating Xendit Invoice', [
            'buyer_id' => $buyer->id,
            'ticket_id' => $ticket->id,
            'amount' => $ticket->price,
            'customer_name' => $request->nama_lengkap
        ]);

        try {
            $xenditService = new XenditService();

            $invoiceData = [
                'external_id' => 'TKT-' . date('Ymd') . '-' . str_pad($buyer->id, 6, '0', STR_PAD_LEFT),
                'description' => 'Pembelian Tiket: ' . $ticket->name . ' - Jersey ' . $request->ukuran_jersey,
                'amount' => $ticket->price,
                'success_url' => route('payment.success'),
                'failure_url' => route('payment.failed'),
                'customer' => [
                    'given_names' => $request->nama_lengkap,
                    'mobile_number' => $request->no_handphone,
                    'addresses' => [
                        [
                            'city' => 'Jakarta',
                            'country' => 'Indonesia',
                            'postal_code' => $request->kode_pos,
                            'state' => 'DKI Jakarta',
                            'street_line1' => $request->alamat_lengkap,
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

            // Redirect ke halaman invoice atau dashboard dengan link pembayaran
            return redirect($invoice['invoice_url']);
        } catch (Exception $e) {
            // Enhanced error logging
            Log::error('Xendit Invoice Creation Failed', [
                'error_message' => $e->getMessage(),
                'buyer_id' => $buyer->id,
                'ticket_id' => $ticket->id,
                'stack_trace' => $e->getTraceAsString()
            ]);

            // Return dengan error message yang lebih detail
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal membuat invoice pembayaran: ' . $e->getMessage())
                ->with('debug_info', 'Silakan cek log untuk detail error');
        }
    }
}
