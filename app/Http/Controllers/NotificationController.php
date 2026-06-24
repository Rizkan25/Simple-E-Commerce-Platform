<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id): RedirectResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    /**
     * Mark a specific notification as read and redirect to the target.
     */
    public function click($id): RedirectResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirect to order page if applicable
        if (isset($notification->data['order_id'])) {
            if (auth()->user()->isSeller()) {
                return redirect()->route('seller.orders.index');
            } else {
                return redirect()->route('orders.show', $notification->data['order_id']);
            }
        }

        // Redirect to withdrawal page if applicable
        if (isset($notification->data['withdrawal_id'])) {
            return redirect('/admin/withdrawals');
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Delete a notification.
     */
    public function destroy($id): RedirectResponse
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
