<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function landing()
    {
        $categories = Category::withCount('products')->get();

        $products = Product::active()
            ->with(['user', 'category'])
            ->latest()
            ->limit(8)
            ->get();

        return view('landing.index', compact('categories', 'products'));
    }

    public function index()
    {
        $user = Auth::user();

        $categories = Category::withCount('products')->limit(6)->get();

        $recommended = collect();

        if ($user?->city) {
            $recommended = Product::active()
                ->with(['user', 'category'])
                ->where('city', $user->city)
                ->latest()
                ->limit(8)
                ->get();

            if ($recommended->count() < 8) {
                $extra = Product::active()
                    ->with(['user', 'category'])
                    ->where('city', '!=', $user->city)
                    ->latest()
                    ->limit(8 - $recommended->count())
                    ->get();

                $recommended = $recommended->concat($extra);
            }
        }

        if ($recommended->isEmpty()) {
            $recommended = Product::active()
                ->with(['user', 'category'])
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('user.home', compact('user', 'categories', 'recommended'));
    }
}