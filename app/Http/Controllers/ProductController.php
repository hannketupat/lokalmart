<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::active()->with(['user', 'category']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $products->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $products->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->input('category'));
            });
        }

        foreach (['province', 'city', 'district'] as $location) {
            if ($request->filled($location)) {
                $products->where($location, $request->input($location));
            }
        }

        if ($request->filled('price_min')) {
            $products->where('price', '>=', $request->integer('price_min'));
        }

        if ($request->filled('price_max')) {
            $products->where('price', '<=', $request->integer('price_max'));
        }

        if ($request->filled('condition') && in_array($request->input('condition'), ['baru', 'bekas'], true)) {
            $products->where('condition', $request->input('condition'));
        }

        $sort = $request->input('sort', 'terbaru');

        if ($sort === 'termurah') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'termahal') {
            $products->orderBy('price', 'desc');
        } elseif ($sort === 'terdekat') {
            $user = $request->user();
            if ($user?->city) {
                $products->orderByRaw('CASE WHEN city = ? THEN 0 ELSE 1 END', [$user->city])->latest();
            } else {
                $products->latest();
            }
        } else {
            $products->latest();
        }

        $products = $products->paginate(12)->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('user.explore', compact('products', 'categories', 'sort'));
    }
}