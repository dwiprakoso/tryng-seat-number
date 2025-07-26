<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CheckinController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameter
        $filterType = $request->get('type', 'all'); // all, buyers, ots

        // Hitung total tiket yang sudah dibayar dari buyers
        $totalPaidTicketsBuyers = DB::table('buyers')
            ->where('payment_status', 'paid')
            ->sum('quantity');

        // Hitung total tiket dari ots_sales
        $totalTicketsOts = DB::table('ots_sales')
            ->sum('quantity');

        // Total gabungan
        $totalPaidTickets = $totalPaidTicketsBuyers + $totalTicketsOts;

        // Hitung total tiket yang sudah checkin dari buyers
        $totalCheckedInBuyers = DB::table('buyer_checkins')
            ->join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->where('buyers.payment_status', 'paid')
            ->sum('buyer_checkins.qty');

        // Hitung total tiket dari ots_sales (dianggap semua sudah checkin karena OTS)
        $totalCheckedInOts = DB::table('ots_sales')
            ->sum('quantity');

        // Total gabungan checkin
        $totalCheckedIn = $totalCheckedInBuyers + $totalCheckedInOts;

        // Ambil data checkin dari buyers
        $buyersCheckins = DB::table('buyer_checkins')
            ->join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->where('buyers.payment_status', 'paid')
            ->select(
                'buyer_checkins.id',
                'buyer_checkins.qty',
                'buyer_checkins.checked_in_at',
                'buyer_checkins.created_at',
                'buyer_checkins.updated_at',
                'buyers.nama_lengkap',
                'buyers.email',
                'buyers.external_id',
                DB::raw("'buyers' as source_table"),
                DB::raw("'Online Booking' as ticket_type")
            );

        // Ambil data dari ots_sales
        $otsCheckins = DB::table('ots_sales')
            ->select(
                'id',
                'quantity as qty',
                'created_at as checked_in_at',
                'created_at',
                'updated_at',
                'nama_lengkap',
                DB::raw("CONCAT('N/A (', no_handphone, ')') as email"),
                DB::raw("CONCAT('OTS-', ticket_id, '-', id) as external_id"),
                DB::raw("'ots_sales' as source_table"),
                DB::raw("'On The Spot' as ticket_type")
            );

        // Gabungkan query berdasarkan filter
        if ($filterType === 'buyers') {
            $query = $buyersCheckins;
        } elseif ($filterType === 'ots') {
            $query = $otsCheckins;
        } else {
            // Union kedua query
            $query = $buyersCheckins->union($otsCheckins);
        }

        // Get all results untuk pagination manual
        $allCheckins = $query->orderBy('checked_in_at', 'desc')->get();

        // Manual pagination
        $perPage = 15;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $checkins = new LengthAwarePaginator(
            $allCheckins->slice($offset, $perPage),
            $allCheckins->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
                'query' => $request->query()
            ]
        );

        // Hitung persentase checkin
        $checkinPercentage = $totalPaidTickets > 0 ? ($totalCheckedIn / $totalPaidTickets) * 100 : 0;

        // Statistik terpisah
        $buyersStats = [
            'total_paid' => $totalPaidTicketsBuyers,
            'total_checkin' => $totalCheckedInBuyers,
            'percentage' => $totalPaidTicketsBuyers > 0 ? ($totalCheckedInBuyers / $totalPaidTicketsBuyers) * 100 : 0
        ];

        $otsStats = [
            'total_tickets' => $totalTicketsOts,
            'total_checkin' => $totalCheckedInOts,
            'percentage' => 100 // OTS dianggap langsung checkin
        ];

        return view('admin.page.checkin.index', compact(
            'totalPaidTickets',
            'totalCheckedIn',
            'checkins',
            'checkinPercentage',
            'buyersStats',
            'otsStats',
            'filterType'
        ));
    }
}
