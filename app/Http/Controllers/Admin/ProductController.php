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
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255', // ✅ Tambahkan validasi location
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->event_date = $request->event_date;
        $product->location = $request->location; // ✅ Simpan location

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
            'location' => 'nullable|string|max:255', // ✅ Validasi lokasi
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->event_date = $request->event_date;
        $product->location = $request->location; // ✅ Simpan lokasi

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('products', 'public');
            $product->avatar = $avatarPath;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully!');
    }
}
