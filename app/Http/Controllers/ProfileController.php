<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(?User $user = null): View
    {
        $user = $user ?? auth()->user();

        $productsCount = $user->products()->where('status', 'active')->count();
        $transactionsCount = $user->buyerTransactions()->count() + $user->sellerTransactions()->count();

        $receivedReviews = $user->receivedReviews()
            ->with('reviewer')
            ->latest()
            ->take(5)
            ->get();

        $avgRating = $user->receivedReviews()->avg('rating') ?? 0;

        $activeProducts = $user->products()
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('profile.show', compact('user', 'productsCount', 'transactionsCount', 'receivedReviews', 'avgRating', 'activeProducts'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'receivedReviews' => $request->user()
                ->receivedReviews()
                ->with('reviewer')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['phone']) && $data['phone'] !== '') {
            $data['phone'] = normalizePhone($data['phone']);
        }

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}