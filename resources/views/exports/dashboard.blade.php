<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
    body, table, td, th {
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 11pt;
    }
    .title {
        font-size: 16pt;
        font-weight: bold;
        color: #f59e0b; /* Orange */
        background-color: #0f172a; /* Dark Blue */
        text-align: center;
        padding: 20px;
    }
    .subtitle {
        font-size: 10pt;
        color: #64748b;
        text-align: center;
        vertical-align: middle;
        padding-top: 10px;
        padding-bottom: 20px;
        border-bottom: 3px solid #f59e0b;
    }
    .section-header {
        font-size: 12pt;
        font-weight: bold;
        background-color: #f59e0b; /* Amber */
        color: #0f172a; /* Dark Blue */
        height: 35px;
        vertical-align: middle;
    }
    .col-header {
        font-weight: bold;
        background-color: #f8fafc;
        color: #334155;
        border-bottom: 2px solid #cbd5e1;
        height: 30px;
        vertical-align: middle;
    }
    .cell {
        border-bottom: 1px solid #e2e8f0;
        height: 25px;
        vertical-align: middle;
    }
    .bold {
        font-weight: bold;
    }
</style>

<table style="border-collapse: collapse; width: 100%;">
    <!-- Header Utama -->
    <tr>
        <th colspan="5" class="title">RINGKASAN DASHBOARD</th>
    </tr>
    <tr>
        <td colspan="5" class="subtitle">Diekspor pada: {{ now()->format('d M Y H:i:s') }}</td>
    </tr>
    <tr><td colspan="5" style="height: 20px;"></td></tr>

    <!-- Ringkasan Metrik -->
    <tr>
        <th colspan="5" class="section-header" style="text-align: left; padding-left: 10px;">RINGKASAN METRIK UTAMA</th>
    </tr>
    <tr>
        <th class="col-header" style="width: 250px; text-align: left; padding-left: 10px;">Indikator</th>
        <th class="col-header" colspan="2" style="width: 200px; text-align: center;">Nilai Saat Ini</th>
        <th colspan="2" style="border-bottom: 2px solid #cbd5e1;"></th>
    </tr>
    <tr>
        <td class="cell bold" style="text-align: left; padding-left: 10px;">Total Pendapatan (GMV)</td>
        <td class="cell bold" style="text-align: right; padding-right: 5px; color: #047857;">Rp</td>
        <td class="cell bold" style="text-align: left; padding-left: 5px; color: #047857;">{{ number_format($totalGmv, 0, ',', '.') }}</td>
        <td colspan="2" style="border-bottom: 1px solid #e2e8f0;"></td>
    </tr>
    <tr>
        <td class="cell bold" style="text-align: left; padding-left: 10px;">Total Pesanan</td>
        <td class="cell" style="text-align: right; padding-right: 5px;">Pesanan</td>
        <td class="cell" style="text-align: left; padding-left: 5px;">{{ number_format($totalOrders, 0, ',', '.') }}</td>
        <td colspan="2" style="border-bottom: 1px solid #e2e8f0;"></td>
    </tr>
    <tr>
        <td class="cell bold" style="text-align: left; padding-left: 10px;">Merchant Aktif</td>
        <td class="cell" style="text-align: right; padding-right: 5px;">Toko</td>
        <td class="cell" style="text-align: left; padding-left: 5px;">{{ number_format($activeMerchants, 0, ',', '.') }}</td>
        <td colspan="2" style="border-bottom: 1px solid #e2e8f0;"></td>
    </tr>
    <tr>
        <td class="cell bold" style="text-align: left; padding-left: 10px;">Pelanggan Baru (Bulan Ini)</td>
        <td class="cell" style="text-align: right; padding-right: 5px;">Orang</td>
        <td class="cell" style="text-align: left; padding-left: 5px;">{{ number_format($newCustomers, 0, ',', '.') }}</td>
        <td colspan="2" style="border-bottom: 1px solid #e2e8f0;"></td>
    </tr>

    <tr><td colspan="5" style="height: 30px;"></td></tr>

    <!-- Daftar Pesanan -->
    <tr>
        <th colspan="5" class="section-header" style="text-align: left; padding-left: 10px;">50 PESANAN TERBARU</th>
    </tr>
    <tr>
        <th class="col-header" style="width: 150px; text-align: center;">No. Pesanan</th>
        <th class="col-header" style="width: 250px; text-align: left; padding-left: 10px;">Pelanggan</th>
        <th class="col-header" style="width: 200px; text-align: right; padding-right: 10px;">Total (Rp)</th>
        <th class="col-header" style="width: 150px; text-align: center;">Status</th>
        <th class="col-header" style="width: 200px; text-align: center;">Tanggal Waktu</th>
    </tr>

    @forelse($recentOrders as $order)
    <tr>
        <td class="cell bold" style="text-align: center;">{{ $order->order_number }}</td>
        <td class="cell" style="text-align: left; padding-left: 10px;">{{ $order->user ? $order->user->name : 'N/A' }}</td>
        <td class="cell" style="text-align: right; padding-right: 10px;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
        <td class="cell" style="text-align: center;
            @if($order->status === 'paid') color: #047857; font-weight: bold;
            @elseif($order->status === 'cancelled') color: #b91c1c; font-weight: bold;
            @elseif($order->status === 'pending') color: #b45309; font-weight: bold;
            @else color: #475569;
            @endif
        ">{{ ucfirst($order->status) }}</td>
        <td class="cell" style="text-align: center;">{{ $order->created_at->format('d M Y H:i') }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="cell" style="text-align: center; color: #94a3b8; font-style: italic; height: 40px;">Tidak ada data pesanan baru.</td>
    </tr>
    @endforelse

</table>
