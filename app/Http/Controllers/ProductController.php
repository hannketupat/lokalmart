<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function show($slug)
    {
        $product = Product::with(['user', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        $product->increment('views');

        $relatedProducts = Product::active()
            ->where('user_id', $product->user_id)
            ->where('id', '!=', $product->id)
            ->with(['user', 'category'])
            ->latest()
            ->limit(4)
            ->get();

        return view('user.product-detail', compact('product', 'relatedProducts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('user.sell', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:1000'],
            'condition' => ['required', 'in:baru,bekas'],
            'description' => ['required', 'string', 'min:20'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'district' => ['required', 'string'],
            'image' => ['required', 'image', 'max:2048'],
            'action' => ['required', 'in:draft,publish'],
        ]);

        $image = $request->file('image')->store('products', 'public');

        Product::create([
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $this->uniqueSlug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'image' => $image,
            'status' => $validated['action'] === 'draft' ? 'draft' : 'pending',
        ]);

        return redirect()
            ->route('products.my')
            ->with('success', 'Produk berhasil disimpan.');
    }

    public function myProducts(Request $request)
    {
        $user = $request->user();

        $base = Product::where('user_id', $user->id)->with(['category']);

        $counts = [
            'semua' => (clone $base)->count(),
            'aktif' => (clone $base)->where('status', 'active')->count(),
            'pending' => (clone $base)->where('status', 'pending')->count(),
            'draft' => (clone $base)->where('status', 'draft')->count(),
            'ditolak' => (clone $base)->where('status', 'rejected')->count(),
            'transaksi' => (clone $base)->whereHas('transactions', function ($query) {
                $query->whereIn('status', ['menunggu', 'disetujui', 'menunggu_cod']);
            })->count(),
            'terjual' => (clone $base)->where('status', 'sold')->count(),
        ];

        $tab = $request->input('tab', 'semua');
        if (! array_key_exists($tab, $counts)) {
            $tab = 'semua';
        }

        if ($tab === 'aktif') {
            $base->where('status', 'active');
        } elseif ($tab === 'pending') {
            $base->where('status', 'pending');
        } elseif ($tab === 'draft') {
            $base->where('status', 'draft');
        } elseif ($tab === 'ditolak') {
            $base->where('status', 'rejected');
        } elseif ($tab === 'transaksi') {
            $base->whereHas('transactions', function ($query) {
                $query->whereIn('status', ['menunggu', 'disetujui', 'menunggu_cod']);
            });
        } elseif ($tab === 'terjual') {
            $base->where('status', 'sold');
        }

        $products = $base->latest()->get();

        return view('user.my-products', compact('products', 'counts', 'tab'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->ensureOwner($product);

        $categories = Category::orderBy('name')->get();

        return view('user.edit-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->ensureOwner($product);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:1000'],
            'condition' => ['required', 'in:baru,bekas'],
            'description' => ['required', 'string', 'min:20'],
            'province' => ['required', 'string'],
            'city' => ['required', 'string'],
            'district' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'province' => $validated['province'],
            'city' => $validated['city'],
            'district' => $validated['district'],
        ];

        if ($validated['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlug($validated['name']);
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('products.my')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->ensureOwner($product);

        $this->deleteImage($product->image);
        $product->delete();

        return redirect()
            ->back()
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $this->ensureOwner($product);

        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status produk berhasil diperbarui.');
    }

    private function ensureOwner(Product $product): void
    {
        if ($product->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke produk ini.');
        }
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $image): void
    {
        if ($image && ! str_starts_with($image, 'http')) {
            Storage::disk('public')->delete($image);
        }
    }
}