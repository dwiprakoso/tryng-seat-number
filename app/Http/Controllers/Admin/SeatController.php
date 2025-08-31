<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    public function index(Request $request)
    {
        $query = Seat::query();

        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $query->where('seat_number', 'like', '%' . $request->search . '%');
        }

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_booked', $request->status);
        }

        // Get paginated results
        $seats = $query->latest()->paginate(15)->withQueryString();

        // Get statistics
        $totalSeats = Seat::count();
        $bookedSeats = Seat::where('is_booked', true)->count();
        $availableSeats = Seat::where('is_booked', false)->count();

        return view('admin.page.seats.index', compact('seats', 'totalSeats', 'bookedSeats', 'availableSeats'));
    }

    public function create()
    {
        return redirect()->route('admin.seats.index')->with('error', 'Gunakan form pada halaman utama untuk menambah kursi.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seat_number' => 'required|string|max:255|unique:seats,seat_number',
            'is_booked' => 'boolean'
        ], [
            'seat_number.required' => 'Nomor kursi harus diisi.',
            'seat_number.string' => 'Nomor kursi harus berupa teks.',
            'seat_number.max' => 'Nomor kursi maksimal 255 karakter.',
            'seat_number.unique' => 'Nomor kursi sudah ada.',
            'is_booked.boolean' => 'Status kursi harus berupa boolean.'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.seats.index')
                ->withErrors($validator)
                ->withInput()
                ->with('showCreateModal', true);
        }

        try {
            Seat::create([
                'seat_number' => $request->seat_number,
                'is_booked' => $request->has('is_booked') ? true : false
            ]);

            return redirect()->route('admin.seats.index')->with('success', 'Kursi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.seats.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Seat $seat)
    {
        return redirect()->route('admin.seats.index');
    }

    public function edit(Seat $seat)
    {
        return redirect()->route('admin.seats.index')->with('error', 'Gunakan form pada halaman utama untuk mengedit kursi.');
    }

    public function update(Request $request, Seat $seat)
    {
        $validator = Validator::make($request->all(), [
            'seat_number' => 'required|string|max:255|unique:seats,seat_number,' . $seat->id,
            'is_booked' => 'boolean'
        ], [
            'seat_number.required' => 'Nomor kursi harus diisi.',
            'seat_number.string' => 'Nomor kursi harus berupa teks.',
            'seat_number.max' => 'Nomor kursi maksimal 255 karakter.',
            'seat_number.unique' => 'Nomor kursi sudah ada.',
            'is_booked.boolean' => 'Status kursi harus berupa boolean.'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.seats.index')
                ->withErrors($validator)
                ->withInput()
                ->with('showEditModal', true)
                ->with('editSeatId', $seat->id);
        }

        try {
            $seat->update([
                'seat_number' => $request->seat_number,
                'is_booked' => $request->has('is_booked') ? true : false
            ]);

            return redirect()->route('admin.seats.index')->with('success', 'Kursi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('admin.seats.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Seat $seat)
    {
        try {
            // Check if seat is currently booked before deleting
            if ($seat->is_booked) {
                return redirect()->route('admin.seats.index')
                    ->with('error', 'Tidak dapat menghapus kursi yang sedang terpesan.');
            }

            $seat->delete();
            return redirect()->route('admin.seats.index')->with('success', 'Kursi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.seats.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
