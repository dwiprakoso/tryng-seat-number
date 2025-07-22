<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer;
use App\Exports\BuyerExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

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
}
