<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class WithdrawalRequestedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Withdrawal $withdrawal)
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Permintaan Penarikan Dana Baru')
                    ->greeting('Halo Admin,')
                    ->line('Ada permintaan penarikan dana baru yang menunggu persetujuan Anda.')
                    ->line('Seller: ' . $this->withdrawal->user->name . ' (' . $this->withdrawal->user->store_name . ')')
                    ->line('Jumlah: Rp ' . number_format($this->withdrawal->amount, 0, ',', '.'))
                    ->line('Bank: ' . $this->withdrawal->bank_account)
                    ->action('Lihat Detail Penarikan', url('/admin/withdrawals'))
                    ->line('Harap segera memproses permintaan ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'withdrawal_id' => $this->withdrawal->id,
            'message' => $this->withdrawal->user->name . ' (' . $this->withdrawal->user->store_name . ') meminta penarikan dana sebesar Rp ' . number_format($this->withdrawal->amount, 0, ',', '.'),
        ];
    }
}
