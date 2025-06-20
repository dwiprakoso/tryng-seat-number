<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('ticket')->get();
        $tickets = Ticket::all();

        return view('admin.page.diskon.index', compact('discounts', 'tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        Discount::create($request->all());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'ticket_id' => 'required|exists:tickets,id'
        ]);

        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}
