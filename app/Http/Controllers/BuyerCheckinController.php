<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\BuyerCheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuyerCheckinController extends Controller
{
    public function index()
    {
        return view('check-in.index');
    }

    public function processCheckin(Request $request)
    {
        $request->validate([
            'external_id_number' => 'required|numeric|digits:6'
        ]);

        // Build full external_id dengan prefix
        $fullExternalId = 'SAMPOOKONG-' . $request->external_id_number;

        try {
            DB::beginTransaction();

            // Cari buyer berdasarkan external_id dengan join ke tabel tickets
            $buyer = Buyer::with('ticket')
                ->where('external_id', $fullExternalId)
                ->first();

            if (!$buyer) {
                return response()->json([
                    'success' => false,
                    'message' => 'External ID tidak ditemukan!'
                ], 404);
            }

            // Validasi payment status
            if ($buyer->payment_status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pembayaran belum lunas! Status: ' . ucfirst($buyer->payment_status)
                ], 400);
            }

            // Cek apakah sudah pernah check-in
            $existingCheckin = BuyerCheckin::where('buyer_id', $buyer->id)->first();
            if ($existingCheckin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sudah pernah check-in pada: ' . $existingCheckin->checked_in_at->format('d/m/Y H:i')
                ], 400);
            }

            // Buat record check-in
            $checkin = BuyerCheckin::create([
                'buyer_id' => $buyer->id,
                'qty' => $buyer->quantity,
                'checked_in_at' => Carbon::now()
            ]);

            DB::commit();

            // Return data untuk print sesuai format thermal receipt
            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'data' => [
                    'checkin_id' => $checkin->id, // Untuk redirect ke receipt
                    'external_id' => $buyer->external_id,
                    'nama_lengkap' => $buyer->nama_lengkap,
                    'email' => $buyer->email,
                    'no_handphone' => $buyer->no_handphone,
                    'ticket_name' => $buyer->ticket->name ?? 'Festival Ticket',
                    'quantity' => $buyer->quantity,
                    'checked_in_at' => $checkin->checked_in_at->format('d/m/Y H:i'),
                    'formatted_id' => str_pad($checkin->id, 3, '0', STR_PAD_LEFT)
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getCheckinHistory()
    {
        $checkins = BuyerCheckin::with(['buyer', 'buyer.ticket'])
            ->orderBy('checked_in_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $checkins
        ]);
    }

    public function getCheckinStats()
    {
        // Hitung total tiket yang sudah dibayar dari buyers
        $totalPaidTicketsBuyers = Buyer::where('payment_status', 'paid')->sum('quantity');

        // Hitung total tiket yang sudah checkin dari buyers
        $totalCheckedInBuyers = BuyerCheckin::join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->where('buyers.payment_status', 'paid')
            ->sum('buyer_checkins.qty');

        // Hitung statistik
        $totalPending = $totalPaidTicketsBuyers - $totalCheckedInBuyers;
        $percentage = $totalPaidTicketsBuyers > 0 ? round(($totalCheckedInBuyers / $totalPaidTicketsBuyers) * 100, 2) : 0;

        return response()->json([
            'success' => true,
            'stats' => [
                'total_paid_tickets' => $totalPaidTicketsBuyers,
                'total_checked_in' => $totalCheckedInBuyers,
                'total_pending' => $totalPending,
                'percentage' => $percentage
            ]
        ]);
    }

    // Method untuk print individual receipt (opsional)
    public function printReceipt($checkinId)
    {
        $checkin = BuyerCheckin::with(['buyer', 'buyer.ticket'])
            ->findOrFail($checkinId);

        return view('check-in.receipt', compact('checkin'));
    }
}
