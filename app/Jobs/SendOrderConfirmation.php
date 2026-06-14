<?php

namespace App\Jobs;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmation implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Order $order
    ) {}

    public function handle(): void
    {
        $order = $this->order->load(['items.product', 'user']);
        Mail::to($order->user->email)->send(new OrderConfirmation($order));
    }
}
