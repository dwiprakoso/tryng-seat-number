<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer;
use App\Exports\BuyerExport;
use Illuminate\Http\Request;
use App\Mail\PaymentRejected;
use App\Mail\PaymentConfirmed;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BuyerController extends Controller
{
    public function index()
    {
        $buyers = Buyer::with(['ticket'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        // Statistik Pendapatan
        $totalRevenue = Buyer::where('payment_status', 'paid')
            ->sum('ticket_price');

        $totalTicketsSold = Buyer::where('payment_status', 'paid')
            ->sum('quantity');

        // Statistik per kategori tiket
        $ticketStats = Buyer::with(['ticket'])
            ->where('payment_status', 'paid')
            ->selectRaw('ticket_id, COUNT(*) as total_orders, SUM(quantity) as total_quantity, SUM(ticket_price) as total_revenue')
            ->groupBy('ticket_id')
            ->get()
            ->map(function ($item) {
                return [
                    'ticket_name' => $item->ticket->name,
                    'total_orders' => $item->total_orders,
                    'total_quantity' => $item->total_quantity,
                    'total_revenue' => $item->total_revenue,
                ];
            });

        return view('admin.page.buyer.index', compact('buyers', 'totalRevenue', 'totalTicketsSold', 'ticketStats'));
    }

    public function export()
    {
        $timestamp = now()->format('Y-m-d');
        return Excel::download(new BuyerExport, "data-pesanan_{$timestamp}.xlsx");
    }

    /**
     * Show payment confirmation page
     */
    public function showPaymentConfirmation($id)
    {
        try {
            $buyer = Buyer::with(['ticket'])->findOrFail($id);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                return redirect()->route('admin.buyer.index')
                    ->with('error', 'Status pembayaran tidak dapat dikonfirmasi');
            }

            return view('admin.page.buyer.confirmation', compact('buyer'));
        } catch (\Exception $e) {
            return redirect()->route('admin.buyer.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(Request $request, $id)
    {
        try {
            $buyer = Buyer::findOrFail($id);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                return redirect()->route('admin.buyer.index')
                    ->with('error', 'Status pembayaran tidak dapat dikonfirmasi');
            }

            $buyer->update([
                'payment_status' => 'paid',
                'payment_confirmed_at' => now()
            ]);

            // Send confirmation email
            try {
                Mail::to($buyer->email)->send(new PaymentConfirmed($buyer));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                Log::error('Failed to send confirmation email: ' . $e->getMessage());
            }

            return redirect()->route('admin.buyer.index')
                ->with('success', 'Pembayaran berhasil dikonfirmasi dan email notifikasi telah dikirim');
        } catch (\Exception $e) {
            return redirect()->route('admin.buyer.index')
                ->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran');
        }
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $buyer = Buyer::findOrFail($id);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                return redirect()->route('admin.buyer.index')
                    ->with('error', 'Status pembayaran tidak dapat ditolak');
            }

            $buyer->update([
                'payment_status' => 'failed',
                'rejection_reason' => $request->reason,
                'updated_at' => now()
            ]);

            // Send rejection email
            try {
                Mail::to($buyer->email)->send(new PaymentRejected($buyer, $request->reason));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                Log::error('Failed to send rejection email: ' . $e->getMessage());
            }

            return redirect()->route('admin.buyer.index')
                ->with('success', 'Pembayaran berhasil ditolak dan email notifikasi telah dikirim');
        } catch (\Exception $e) {
            return redirect()->route('admin.buyer.index')
                ->with('error', 'Terjadi kesalahan saat menolak pembayaran');
        }
    }
}
