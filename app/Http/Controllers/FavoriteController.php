<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = Favorite::where('user_id', $request->user()->id)
            ->with(['product.user', 'product.category'])
            ->latest()
            ->get()
            ->pluck('product')
            ->filter(fn ($product) => $product && $product->status === 'active')
            ->values();

        return view('user.favorites', compact('favorites'));
    }

    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $favorited = true;
        }

        $count = Favorite::where('user_id', $user->id)->count();

        if ($request->expectsJson()) {
            return response()->json([
                'favorited' => $favorited,
                'count' => $count,
            ]);
        }

        return back()->with(
            'success',
            $favorited ? 'Produk ditambahkan ke favorit.' : 'Produk dihapus dari favorit.'
        );
    }
}
