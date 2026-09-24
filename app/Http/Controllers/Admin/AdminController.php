<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Report;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'transactions' => Transaction::count(),
            'reports' => Report::where('status', 'pending')->count(),
        ];

        $recentActivity = collect();

        $recentUsers = User::latest()->take(3)->get();
        foreach ($recentUsers as $user) {
            $recentActivity->push([
                'type' => 'user',
                'description' => "Pengguna baru mendaftar: {$user->name}",
                'time' => $user->created_at->diffForHumans(),
                'link' => route('admin.users.show', $user),
            ]);
        }

        $recentProducts = Product::with('user')->latest()->take(3)->get();
        foreach ($recentProducts as $product) {
            $recentActivity->push([
                'type' => 'product',
                'description' => "Produk baru: {$product->name} oleh {$product->user->name}",
                'time' => $product->created_at->diffForHumans(),
                'link' => route('admin.products.show', $product),
            ]);
        }

        $recentTransactions = Transaction::with(['buyer', 'seller'])->latest()->take(3)->get();
        foreach ($recentTransactions as $transaction) {
            $recentActivity->push([
                'type' => 'transaction',
                "description" => "Transaksi baru: {$transaction->buyer->name} membeli dari {$transaction->seller->name}",
                'time' => $transaction->created_at->diffForHumans(),
                'link' => route('admin.transactions.show', $transaction),
            ]);
        }

        $recentReports = Report::with('reporter')->where('status', 'pending')->latest()->take(3)->get();
        foreach ($recentReports as $report) {
            $recentActivity->push([
                'type' => 'report',
                "description" => "Laporan baru dari {$report->reporter->name}",
                'time' => $report->created_at->diffForHumans(),
                'link' => route('admin.reports.show', $report),
            ]);
        }

        $recentActivity = $recentActivity->sortByDesc(function ($a) {
            return $a['time'];
        })->take(10)->values();

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }
}