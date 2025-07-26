<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function index()
    {
        // Hitung total tiket yang sudah dibayar (paid)
        $totalPaidTickets = DB::table('buyers')
            ->where('payment_status', 'paid')
            ->sum('quantity');

        // Hitung total tiket yang sudah checkin
        $totalCheckedIn = DB::table('buyer_checkins')
            ->join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->where('buyers.payment_status', 'paid')
            ->sum('buyer_checkins.qty');

        // Ambil data checkin dengan informasi buyer
        $checkins = DB::table('buyer_checkins')
            ->join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->where('buyers.payment_status', 'paid')
            ->select(
                'buyer_checkins.*',
                'buyers.nama_lengkap',
                'buyers.email',
                'buyers.external_id'
            )
            ->orderBy('buyer_checkins.checked_in_at', 'desc')
            ->paginate(15);

        // Hitung persentase checkin
        $checkinPercentage = $totalPaidTickets > 0 ? ($totalCheckedIn / $totalPaidTickets) * 100 : 0;

        return view('admin.page.checkin.index', compact(
            'totalPaidTickets',
            'totalCheckedIn',
            'checkins',
            'checkinPercentage'
        ));
    }
}
