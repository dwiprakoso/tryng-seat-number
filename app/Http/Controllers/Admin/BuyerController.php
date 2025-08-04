<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer;
use App\Exports\BuyerExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

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
     * Get payment proof details for confirmation modal
     */
    public function getPaymentProof($id): JsonResponse
    {
        try {
            $buyer = Buyer::with(['ticket'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $buyer->id,
                    'external_id' => $buyer->external_id,
                    'nama_lengkap' => $buyer->nama_lengkap,
                    'email' => $buyer->email,
                    'no_handphone' => $buyer->no_handphone,
                    'ticket_name' => $buyer->ticket->name,
                    'quantity' => $buyer->quantity,
                    'ticket_price' => $buyer->ticket_price,
                    'admin_fee' => $buyer->admin_fee,
                    'total_amount' => $buyer->total_amount,
                    'payment_proof' => $buyer->payment_proof,
                    'payment_status' => $buyer->payment_status,
                    'created_at' => $buyer->created_at->format('d/m/Y H:i'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(Request $request, $id): JsonResponse
    {
        try {
            $buyer = Buyer::findOrFail($id);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                return response()->json([
                    'success' => false,
                    'message' => 'Status pembayaran tidak dapat dikonfirmasi'
                ], 400);
            }

            $buyer->update([
                'payment_status' => 'paid',
                'payment_confirmed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengkonfirmasi pembayaran'
            ], 500);
        }
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, $id): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $buyer = Buyer::findOrFail($id);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                return response()->json([
                    'success' => false,
                    'message' => 'Status pembayaran tidak dapat ditolak'
                ], 400);
            }

            $buyer->update([
                'payment_status' => 'failed',
                'rejection_reason' => $request->reason,
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil ditolak'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak pembayaran'
            ], 500);
        }
    }
}
