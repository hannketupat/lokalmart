<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('status', 'all');

        $counts = [
            'all' => Product::count(),
            'pending' => Product::pending()->count(),
            'active' => Product::active()->count(),
            'rejected' => Product::where('status', 'rejected')->count(),
        ];

        $products = Product::with('user', 'category');

        if (in_array($status, ['pending', 'active', 'rejected'], true)) {
            $products->where('status', $status);
        }

        $products = $products->latest()->paginate(20)->withQueryString();

        return view('admin.products.index', compact('products', 'counts', 'status'));
    }

    public function approve(Product $product)
    {
        $product->update([
            'status' => 'active',
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Produk "' . $product->name . '" disetujui dan sekarang aktif.');
    }

    public function reject(Request $request, Product $product)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $product->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'],
        ]);

        return back()->with('success', 'Produk "' . $product->name . '" ditolak.');
    }

    public function show(Product $product): View
    {
        $product->load('user', 'category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:draft,pending,active,inactive,rejected,sold',
            'condition' => 'required|in:baru,bekas',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
        ]);

        $product->update($request->only(['name', 'description', 'price', 'status', 'condition', 'city', 'province']));

        return back()->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }
}
