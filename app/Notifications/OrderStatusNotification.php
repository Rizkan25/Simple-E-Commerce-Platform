<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusMessage = match ($this->order->status) {
            'paid' => 'sedang diproses',
            'shipped' => 'telah dikirim',
            'completed' => 'telah selesai',
            'cancelled' => 'dibatalkan',
            default => 'diperbarui',
        };

        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'message' => 'Pesanan #' . $this->order->order_number . ' Anda ' . $statusMessage . '.',
        ];
    }
}
