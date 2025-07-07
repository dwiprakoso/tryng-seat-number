<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('admin.page.ticket.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:published,scheduled,inactive'
        ]);

        Ticket::create($request->all());

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:published,scheduled,inactive'
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
    public function verify($external_id)
    {
        // Redirect ke https://ticketify.id untuk testing
        return redirect('https://ticketify.id');
    }
}
