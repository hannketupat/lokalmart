<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = Transaction::with(['product', 'buyer', 'seller'])
            ->where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->latest()
            ->get();

        return view('user.transactions', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->buyer_id !== $user->id && $transaction->seller_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $transaction->load(['product', 'buyer', 'seller', 'reviews.reviewer', 'reviews.transaction']);

        return view('user.transaction-detail', compact('transaction'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'cod_location' => ['required', 'string', 'max:255'],
            'cod_date' => ['required', 'date', 'after_or_equal:today'],
            'cod_time' => ['required', 'date_format:H:i'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->status !== 'active') {
            return back()->with('error', 'Produk ini tidak tersedia untuk COD.');
        }

        if ($product->user_id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa melakukan COD terhadap produkmu sendiri.');
        }

        $alreadyBooked = Transaction::where('product_id', $product->id)
            ->whereIn('status', ['menunggu', 'disetujui', 'menunggu_cod'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Produk ini sudah memiliki transaksi yang sedang berjalan.');
        }

        Transaction::create([
            'product_id' => $product->id,
            'buyer_id' => auth()->id(),
            'seller_id' => $product->user_id,
            'price' => $product->price,
            'cod_location' => $validated['cod_location'],
            'cod_date' => $validated['cod_date'],
            'cod_time' => $validated['cod_time'],
            'note' => $validated['note'],
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Permintaan COD berhasil diajukan. Menunggu persetujuan penjual.');
    }

    public function approve(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->seller_id !== $user->id) {
            abort(403, 'Hanya penjual yang bisa menyetujui transaksi.');
        }

        if ($transaction->status !== 'menunggu') {
            return back()->with('error', 'Transaksi tidak bisa disetujui pada status ini.');
        }

        $transaction->update(['status' => 'disetujui']);

        return back()->with('success', 'Transaksi disetujui. Menunggu COD.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->seller_id !== $user->id) {
            abort(403, 'Hanya penjual yang bisa menolak transaksi.');
        }

        if ($transaction->status !== 'menunggu') {
            return back()->with('error', 'Transaksi tidak bisa ditolak pada status ini.');
        }

        $transaction->update(['status' => 'ditolak']);

        return back()->with('success', 'Transaksi ditolak.');
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->buyer_id !== $user->id) {
            abort(403, 'Hanya pembeli yang bisa membatalkan transaksi.');
        }

        if ($transaction->status !== 'menunggu') {
            return back()->with('error', 'Transaksi tidak bisa dibatalkan pada status ini.');
        }

        $transaction->update(['status' => 'ditolak']);

        return back()->with('success', 'Transaksi dibatalkan.');
    }

    public function complete(Request $request, Transaction $transaction)
    {
        $user = Auth::user();

        if ($transaction->buyer_id !== $user->id && $transaction->seller_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($transaction->status !== 'menunggu_cod') {
            return back()->with('error', 'Transaksi tidak bisa diselesaikan pada status ini.');
        }

        $transaction->update(['status' => 'selesai']);

        $product = $transaction->product;
        $product->update(['status' => 'sold']);

        $seller = $transaction->seller;
        $seller->increment('total_transactions');

        return back()->with('success', 'Transaksi selesai. Terima kasih sudah bertransaksi di LokalMart!');
    }
}