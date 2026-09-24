<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(): View
    {
        $transactions = Transaction::with(['buyer', 'seller', 'product'])->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load('buyer', 'seller', 'product', 'reviews');
        return view('admin.transactions.show', compact('transaction'));
    }
}
