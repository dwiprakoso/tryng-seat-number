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

        // Statistik Pendapatan - Ubah 'paid' menjadi 'confirmed'
        $totalRevenue = Buyer::where('payment_status', 'confirmed')
            ->sum('ticket_price');

        $totalTicketsSold = Buyer::where('payment_status', 'confirmed')
            ->sum('quantity');

        // Statistik per kategori tiket - Ubah 'paid' menjadi 'confirmed'
        $ticketStats = Buyer::with(['ticket'])
            ->where('payment_status', 'confirmed')
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
            Log::error('Error in showPaymentConfirmation: ' . $e->getMessage(), [
                'buyer_id' => $id,
                'stack_trace' => $e->getTraceAsString()
            ]);
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
            Log::info('Confirming payment for buyer ID: ' . $id);

            $buyer = Buyer::findOrFail($id);
            Log::info('Buyer found', ['buyer_id' => $buyer->id, 'status' => $buyer->payment_status]);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                Log::warning('Invalid payment status for confirmation', [
                    'buyer_id' => $id,
                    'current_status' => $buyer->payment_status
                ]);
                return redirect()->route('admin.buyer.index')
                    ->with('error', 'Status pembayaran tidak dapat dikonfirmasi');
            }

            // Update buyer status - UBAH 'paid' menjadi 'confirmed'
            Log::info('Updating buyer payment status');
            $buyer->update([
                'payment_status' => 'confirmed', // ← PERBAIKAN DI SINI
                'payment_confirmed_at' => now()
            ]);
            Log::info('Buyer payment status updated successfully');

            // Send confirmation email
            try {
                Log::info('Sending confirmation email to: ' . $buyer->email);
                Mail::to($buyer->email)->send(new PaymentConfirmed($buyer));
                Log::info('Confirmation email sent successfully');
            } catch (\Exception $emailException) {
                // Log error but don't stop the process
                Log::error('Failed to send confirmation email: ' . $emailException->getMessage(), [
                    'buyer_id' => $id,
                    'buyer_email' => $buyer->email,
                    'stack_trace' => $emailException->getTraceAsString()
                ]);
            }

            Log::info('Payment confirmation completed successfully');
            return redirect()->route('admin.buyer.index')
                ->with('success', 'Pembayaran berhasil dikonfirmasi dan email notifikasi telah dikirim');
        } catch (\Exception $e) {
            Log::error('Error in confirmPayment: ' . $e->getMessage(), [
                'buyer_id' => $id,
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return redirect()->route('admin.buyer.index')
                ->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Reject payment
     */
    public function rejectPayment(Request $request, $id)
    {
        try {
            Log::info('Rejecting payment for buyer ID: ' . $id);

            // Validate request
            $validatedData = $request->validate([
                'reason' => 'required|string|max:500'
            ]);
            Log::info('Request validation passed', $validatedData);

            $buyer = Buyer::findOrFail($id);
            Log::info('Buyer found', ['buyer_id' => $buyer->id, 'status' => $buyer->payment_status]);

            if ($buyer->payment_status !== 'waiting_confirmation') {
                Log::warning('Invalid payment status for rejection', [
                    'buyer_id' => $id,
                    'current_status' => $buyer->payment_status
                ]);
                return redirect()->route('admin.buyer.index')
                    ->with('error', 'Status pembayaran tidak dapat ditolak');
            }

            // Update buyer status
            Log::info('Updating buyer payment status to rejected');
            $buyer->update([
                'payment_status' => 'rejected',
                'rejection_reason' => $request->reason,
                'updated_at' => now()
            ]);
            Log::info('Buyer payment status updated to rejected successfully');

            // Send rejection email
            try {
                Log::info('Sending rejection email to: ' . $buyer->email);
                Mail::to($buyer->email)->send(new PaymentRejected($buyer, $request->reason));
                Log::info('Rejection email sent successfully');
            } catch (\Exception $emailException) {
                // Log error but don't stop the process
                Log::error('Failed to send rejection email: ' . $emailException->getMessage(), [
                    'buyer_id' => $id,
                    'buyer_email' => $buyer->email,
                    'reason' => $request->reason,
                    'stack_trace' => $emailException->getTraceAsString()
                ]);
            }

            Log::info('Payment rejection completed successfully');
            return redirect()->route('admin.buyer.index')
                ->with('success', 'Pembayaran berhasil ditolak dan email notifikasi telah dikirim');
        } catch (\Exception $e) {
            Log::error('Error in rejectPayment: ' . $e->getMessage(), [
                'buyer_id' => $id,
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return redirect()->route('admin.buyer.index')
                ->with('error', 'Terjadi kesalahan saat menolak pembayaran: ' . $e->getMessage());
        }
    }
}
