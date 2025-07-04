<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalProducts = Product::count();
        $totalTickets = Ticket::count();
        $totalBuyers = Buyer::count();
        $totalRevenue = Buyer::where('payment_status', 'paid')->sum('total_amount') ?? 0;

        // Recent Statistics (Last 30 days)
        $recentBuyers = Buyer::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $recentRevenue = Buyer::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('total_amount') ?? 0;

        // Payment Status Distribution - Using Collection groupBy
        $allBuyers = Buyer::all();
        $paymentStatusData = $allBuyers->groupBy('payment_status')->map->count();

        // Top Selling Products - Using ORM relationships
        $topProducts = Product::with(['tickets.buyers' => function ($query) {
            $query->where('payment_status', 'paid');
        }])->get()->map(function ($product) {
            $totalBuyers = $product->tickets->sum(function ($ticket) {
                return $ticket->buyers->count();
            });
            $product->total_buyers = $totalBuyers;
            return $product;
        })->sortByDesc('total_buyers')->take(5);

        // Recent Orders
        $recentOrders = Buyer::with('ticket.product')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ticket Sales by Category - Using ORM
        $ticketSales = Ticket::with(['buyers' => function ($query) {
            $query->where('payment_status', 'paid');
        }])->get()->map(function ($ticket) {
            $ticket->total_sold = $ticket->buyers->count();
            return $ticket;
        })->sortByDesc('total_sold');

        // Upcoming Events
        $upcomingEvents = Product::where('event_date', '>=', Carbon::now())
            ->with('tickets')
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();

        // Monthly Revenue - Using Collection groupBy with Carbon
        $paidBuyers = Buyer::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->get();

        $monthlyRevenue = $paidBuyers->groupBy(function ($buyer) {
            return Carbon::parse($buyer->created_at)->format('Y-m');
        })->map(function ($buyers, $month) {
            return (object) [
                'month' => $month,
                'revenue' => $buyers->sum('total_amount'),
                'orders' => $buyers->count()
            ];
        })->sortBy('month')->values();

        return view('admin.index', compact(
            'totalProducts',
            'totalTickets',
            'totalBuyers',
            'totalRevenue',
            'recentBuyers',
            'recentRevenue',
            'paymentStatusData',
            'monthlyRevenue',
            'topProducts',
            'recentOrders',
            'ticketSales',
            'upcomingEvents'
        ));
    }
}
