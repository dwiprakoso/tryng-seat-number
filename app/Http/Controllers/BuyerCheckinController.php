<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\BuyerCheckin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'external_id_number' => 'required|string|min:6'
        ]);

        // Ambil input external_id_number
        $externalIdNumber = $request->external_id_number;

        // Log input untuk debugging
        Log::info('Check-in attempt', [
            'input' => $externalIdNumber,
            'input_length' => strlen($externalIdNumber)
        ]);

        try {
            DB::beginTransaction();

            $buyer = null;

            // Jika input hanya 6 digit angka
            if (preg_match('/^\d{6}$/', $externalIdNumber)) {
                Log::info('Processing 6-digit input', ['input' => $externalIdNumber]);

                // Debug: Cek semua external_id yang ada
                $allExternalIds = Buyer::select('external_id')->pluck('external_id')->toArray();
                Log::info('All external IDs in database', $allExternalIds);

                // Method 1: LIKE query (yang sekarang)
                $buyer = Buyer::with('ticket')
                    ->where('external_id', 'LIKE', '%-' . $externalIdNumber)
                    ->first();

                Log::info('LIKE query result', [
                    'pattern' => '%-' . $externalIdNumber,
                    'found' => $buyer ? 'YES' : 'NO',
                    'buyer_id' => $buyer ? $buyer->id : null,
                    'external_id' => $buyer ? $buyer->external_id : null
                ]);

                // Method 2: Fallback dengan SUBSTRING
                if (!$buyer) {
                    Log::info('Trying SUBSTRING method');
                    $buyer = Buyer::with('ticket')
                        ->whereRaw('RIGHT(external_id, 6) = ?', [$externalIdNumber])
                        ->first();

                    Log::info('SUBSTRING query result', [
                        'found' => $buyer ? 'YES' : 'NO',
                        'buyer_id' => $buyer ? $buyer->id : null,
                        'external_id' => $buyer ? $buyer->external_id : null
                    ]);
                }

                // Method 3: Manual check dengan PHP (untuk debug)
                if (!$buyer) {
                    Log::info('Trying manual PHP check');
                    $allBuyers = Buyer::with('ticket')->get();
                    foreach ($allBuyers as $b) {
                        if (substr($b->external_id, -6) === $externalIdNumber) {
                            $buyer = $b;
                            Log::info('Found with PHP method', [
                                'buyer_id' => $buyer->id,
                                'external_id' => $buyer->external_id
                            ]);
                            break;
                        }
                    }
                }

                if (!$buyer) {
                    // Debug: Cari yang mirip
                    $similarBuyers = Buyer::where('external_id', 'LIKE', '%' . $externalIdNumber . '%')->get();
                    Log::info('Similar external IDs found', [
                        'count' => $similarBuyers->count(),
                        'similar_ids' => $similarBuyers->pluck('external_id')->toArray()
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'External ID tidak ditemukan! Format: ORDER-YYYYMMDD-XXXXXX atau 6 digit terakhir',
                        'debug' => [
                            'input' => $externalIdNumber,
                            'pattern_used' => '%-' . $externalIdNumber,
                            'total_buyers' => Buyer::count(),
                            'similar_count' => $similarBuyers->count(),
                            'similar_ids' => $similarBuyers->pluck('external_id')->toArray()
                        ]
                    ], 404);
                }

                return $this->processCheckinForBuyer($buyer);
            }

            // Handle format lainnya
            $fullExternalId = null;

            // Jika input sudah dalam format ORDER-YYYYMMDD-XXXXXX
            if (preg_match('/^ORDER-\d{8}-\d{6}$/', $externalIdNumber)) {
                $fullExternalId = $externalIdNumber;
            }
            // Jika input hanya YYYYMMDD-XXXXXX, tambahkan prefix ORDER-
            elseif (preg_match('/^\d{8}-\d{6}$/', $externalIdNumber)) {
                $fullExternalId = 'ORDER-' . $externalIdNumber;
            }
            // Format lama (6 digit dengan prefix ORDER-)
            elseif (preg_match('/^\d{6}$/', $externalIdNumber)) {
                $fullExternalId = 'ORDER-' . $externalIdNumber;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Format External ID tidak valid! Gunakan: ORDER-YYYYMMDD-XXXXXX, YYYYMMDD-XXXXXX, atau 6 digit terakhir'
                ], 400);
            }

            if ($fullExternalId) {
                Log::info('Processing full external ID', ['full_id' => $fullExternalId]);

                $buyer = Buyer::with('ticket')
                    ->where('external_id', $fullExternalId)
                    ->first();

                if (!$buyer) {
                    return response()->json([
                        'success' => false,
                        'message' => 'External ID tidak ditemukan!',
                        'debug' => [
                            'searched_id' => $fullExternalId,
                            'total_buyers' => Buyer::count()
                        ]
                    ], 404);
                }
            }

            return $this->processCheckinForBuyer($buyer);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Check-in error', [
                'input' => $externalIdNumber,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processCheckinForBuyer($buyer)
    {
        try {
            Log::info('Processing check-in for buyer', [
                'buyer_id' => $buyer->id,
                'external_id' => $buyer->external_id,
                'payment_status' => $buyer->payment_status
            ]);

            // Validasi payment status
            if ($buyer->payment_status !== 'paid' && $buyer->payment_status !== 'confirmed') {
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

            Log::info('Check-in successful', [
                'checkin_id' => $checkin->id,
                'buyer_id' => $buyer->id,
                'external_id' => $buyer->external_id
            ]);

            // Return data untuk print sesuai format thermal receipt
            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'data' => [
                    'checkin_id' => $checkin->id,
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
            Log::error('Check-in processing error', [
                'buyer_id' => $buyer->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk debug - cek data di database
    public function debugExternalIds()
    {
        $buyers = Buyer::select('id', 'external_id', 'payment_status', 'nama_lengkap')
            ->orderBy('external_id')
            ->get();

        return response()->json([
            'total_buyers' => $buyers->count(),
            'buyers' => $buyers->map(function ($buyer) {
                return [
                    'id' => $buyer->id,
                    'external_id' => $buyer->external_id,
                    'last_6_digits' => substr($buyer->external_id, -6),
                    'payment_status' => $buyer->payment_status,
                    'nama_lengkap' => $buyer->nama_lengkap
                ];
            })
        ]);
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
        $totalPaidTicketsBuyers = Buyer::whereIn('payment_status', ['paid', 'confirmed'])->sum('quantity');

        // Hitung total tiket yang sudah checkin dari buyers
        $totalCheckedInBuyers = BuyerCheckin::join('buyers', 'buyer_checkins.buyer_id', '=', 'buyers.id')
            ->whereIn('buyers.payment_status', ['paid', 'confirmed'])
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
        $checkin = BuyerCheckin::with([
            'buyer',
            'buyer.ticket',
            'buyer.bookingSeats',
            'buyer.bookingSeats.seat'
        ])->findOrFail($checkinId);

        return view('check-in.receipt', compact('checkin'));
    }
}
