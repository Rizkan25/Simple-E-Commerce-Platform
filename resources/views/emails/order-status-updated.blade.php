<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #1f2937;">Status Pesanan Diperbarui</h2>

    <p>Halo {{ $order->user->name }},</p>

    <p>Status pesanan Anda telah diperbarui:</p>

    <div style="background: #f3f4f6; padding: 16px; border-radius: 8px; margin: 16px 0;">
        <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
        <p><strong>Status Baru:</strong>
            <span style="display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 600;
                @switch($order->status)
                    @case('paid') background: #dbeafe; color: #1e40af; @break
                    @case('shipped') background: #fef3c7; color: #92400e; @break
                    @case('completed') background: #d1fae5; color: #065f46; @break
                    @case('cancelled') background: #fee2e2; color: #991b1b; @break
                    @default background: #e5e7eb; color: #374151;
                @endswitch
            ">{{ ucfirst($order->status) }}</span>
        </p>
    </div>

    <p style="margin-top: 20px; color: #6b7280; font-size: 14px;">
        Terima kasih telah berbelanja di toko kami.
    </p>
</div>
