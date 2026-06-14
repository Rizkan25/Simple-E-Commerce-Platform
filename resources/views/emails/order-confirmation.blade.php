<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="color: #1f2937;">Konfirmasi Pesanan</h2>

    <p>Halo {{ $order->user->name }},</p>

    <p>Terima kasih atas pesanan Anda! Berikut adalah detail pesanan:</p>

    <div style="background: #f3f4f6; padding: 16px; border-radius: 8px; margin: 16px 0;">
        <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Transfer Bank' }}</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
        <thead>
            <tr style="background: #e5e7eb;">
                <th style="padding: 8px; text-align: left;">Produk</th>
                <th style="padding: 8px; text-align: center;">Qty</th>
                <th style="padding: 8px; text-align: right;">Harga</th>
                <th style="padding: 8px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr style="border-bottom: 1px solid #e5e7eb;">
                <td style="padding: 8px;">{{ $item->product->name ?? 'Produk dihapus' }}</td>
                <td style="padding: 8px; text-align: center;">{{ $item->quantity }}</td>
                <td style="padding: 8px; text-align: right;">Rp {{ number_format($item->price_at_order, 0, ',', '.') }}</td>
                <td style="padding: 8px; text-align: right;">Rp {{ number_format($item->price_at_order * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="padding: 8px; text-align: right;"><strong>Total:</strong></td>
                <td style="padding: 8px; text-align: right;"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div style="background: #f3f4f6; padding: 16px; border-radius: 8px;">
        <p><strong>Alamat Pengiriman:</strong></p>
        <p>{{ $order->shipping_address }}</p>
    </div>

    <p style="margin-top: 20px; color: #6b7280; font-size: 14px;">
        Jika Anda memiliki pertanyaan, silakan hubungi kami.
    </p>
</div>
