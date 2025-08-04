<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::first();
        return view('admin.page.event.index', compact('product'));
    }

    public function store(Request $request)
    {
        // Debug: Cek data yang diterima
        // dd($request->all()); // Uncomment untuk debug

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'event_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:event_date', // ✅ Validasi end_date harus setelah event_date
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->event_date = $request->event_date;
        $product->end_date = $request->end_date; // ✅ Pastikan ini ada
        $product->location = $request->location;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('products', 'public');
            $product->avatar = $avatarPath;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'event_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:event_date', // ✅ Tambahkan validasi end_date
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->event_date = $request->event_date;
        $product->end_date = $request->end_date; // ✅ Tambahkan ini yang hilang!
        $product->location = $request->location;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('products', 'public');
            $product->avatar = $avatarPath;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully!');
    }
}
