<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtsSales;
use App\Models\Ticket;
use App\Exports\OtsSalesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OtsSalesController extends Controller
{
    public function index()
    {
        $otsSales = OtsSales::with('ticket')->orderBy('created_at', 'desc')->get();
        $tickets = Ticket::where('status', 'scheduled')->get();

        return view('admin.page.ots-sales.index', compact('otsSales', 'tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_handphone' => 'required|string|max:20',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,cashless'
        ]);

        DB::beginTransaction();

        try {
            $ticket = Ticket::findOrFail($request->ticket_id);

            // Check ticket availability
            if ($ticket->qty < $request->quantity) {
                return back()->with('error', 'Jumlah tiket tidak mencukupi');
            }

            // Calculate amounts
            $ticketPrice = $ticket->price;
            $subtotal = $ticketPrice * $request->quantity;
            $adminFee = $request->payment_method === 'cashless' ? $subtotal * 0.05 : 0;
            $totalAmount = $subtotal + $adminFee;

            // Create OTS sale
            $otsSale = OtsSales::create([
                'nama_lengkap' => $request->nama_lengkap,
                'no_handphone' => $request->no_handphone,
                'ticket_id' => $request->ticket_id,
                'quantity' => $request->quantity,
                'ticket_price' => $ticketPrice,
                'admin_fee' => $adminFee,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
            ]);

            // Update ticket quantity
            $ticket->decrement('qty', $request->quantity);

            DB::commit();

            return redirect()->route('admin.ots-sales.receipt', $otsSale->id)
                ->with('success', 'Penjualan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function receipt($id)
    {
        $otsSale = OtsSales::with('ticket')->findOrFail($id);

        return view('admin.page.ots-sales.receipt', compact('otsSale'));
    }

    public function destroy($id)
    {
        try {
            $otsSale = OtsSales::findOrFail($id);

            // Return ticket quantity
            $ticket = Ticket::findOrFail($otsSale->ticket_id);
            $ticket->increment('qty', $otsSale->quantity);

            $otsSale->delete();

            return back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            $fileName = 'ots-sales-' . date('Y-m-d-H-i-s') . '.xlsx';

            return Excel::download(new OtsSalesExport, $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat export data: ' . $e->getMessage());
        }
    }
}
