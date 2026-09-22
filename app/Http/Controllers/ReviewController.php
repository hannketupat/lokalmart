<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        $user = $request->user();

        if ($transaction->buyer_id !== $user->id && $transaction->seller_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($transaction->status !== 'selesai') {
            return back()->with('error', 'Hanya transaksi berstatus selesai yang bisa dirating.');
        }

        $alreadyReviewed = Review::where('transaction_id', $transaction->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Kamu sudah memberi rating untuk transaksi ini.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:500'],
        ]);

        $reviewedId = $user->id === $transaction->buyer_id
            ? $transaction->seller_id
            : $transaction->buyer_id;

        Review::create([
            'transaction_id' => $transaction->id,
            'reviewer_id' => $user->id,
            'reviewed_id' => $reviewedId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        $avgRating = Review::where('reviewed_id', $reviewedId)->avg('rating') ?? 0;

        User::where('id', $reviewedId)->update([
            'rating' => round($avgRating, 1),
        ]);

        return back()->with('success', 'Rating berhasil dikirim');
    }
}
