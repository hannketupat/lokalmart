<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()
            ->notifications()
            ->orderByDesc('created_at')
            ->paginate(20);

        $unreadCount = $request->user()->unreadNotificationsCount();

        $counts = [
            'all' => $request->user()->notifications()->count(),
            'transaksi' => $request->user()->notifications()->where('type', 'transaksi')->count(),
            'chat' => $request->user()->notifications()->where('type', 'chat')->count(),
            'sistem' => $request->user()->notifications()->where('type', 'sistem')->count(),
        ];

        return view('user.notifications', compact('notifications', 'unreadCount', 'counts'));
    }

    public function markRead(Request $request, Notification $notification): RedirectResponse
    {
        $this->authorize('update', $notification);

        $notification->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca');
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sebagai dibaca');
    }
}