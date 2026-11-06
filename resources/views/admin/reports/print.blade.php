<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ $months[$month] }} {{ $year }} | MountainTrip</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Montserrat:wght@800;900&display=swap" rel="stylesheet">
    <style>
        :root { --primary:#1a6b3a; --secondary:#ff6b35; --dark:#0d1b2a; }
        *{ box-sizing:border-box; }
        body{ font-family:'Poppins',sans-serif; font-size:11pt; color:#1a1a1a; background:#fff; margin:0; padding:0; }
        .page-wrap{ max-width:900px; margin:0 auto; padding:2rem 2.5rem; }
        /* Header */
        .report-header{ display:flex; align-items:flex-start; justify-content:space-between; padding-bottom:1.25rem; border-bottom:3px solid var(--primary); margin-bottom:2rem; }
        .brand-name{ font-family:'Montserrat',sans-serif; font-weight:900; font-size:1.6rem; color:var(--primary); margin-bottom:.2rem; }
        .brand-name span{ color:var(--secondary); }
        .brand-sub{ font-size:.78rem; color:#888; }
        .report-title-right{ text-align:right; }
        .report-title-right h2{ font-family:'Montserrat',sans-serif; font-weight:800; font-size:1.1rem; color:var(--dark); margin-bottom:.2rem; }
        .report-title-right .period{ font-size:.85rem; color:#555; font-weight:600; }
        .report-title-right .generated{ font-size:.72rem; color:#aaa; margin-top:.2rem; }
        /* Metrics */
        .metrics-grid{ display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:2rem; }
        .metric-box{ border:1.5px solid #e4eaf0; border-radius:12px; padding:1rem 1.2rem; }
        .metric-box.highlight{ background:linear-gradient(135deg,var(--primary),#2d9a56); border-color:transparent; }
        .m-label{ font-size:.7rem; text-transform:uppercase; letter-spacing:.8px; color:#888; font-weight:600; margin-bottom:.3rem; }
        .metric-box.highlight .m-label{ color:rgba(255,255,255,.75); }
        .m-value{ font-family:'Montserrat',sans-serif; font-weight:900; font-size:1.3rem; color:var(--dark); }
        .metric-box.highlight .m-value{ color:#fff; font-size:1.1rem; }
        .m-sub{ font-size:.7rem; color:#aaa; margin-top:.2rem; }
        .metric-box.highlight .m-sub{ color:rgba(255,255,255,.6); }
        /* Section heading */
        .section-heading{ font-family:'Montserrat',sans-serif; font-weight:800; font-size:.92rem; color:var(--dark); border-left:4px solid var(--primary); padding-left:.75rem; margin:1.75rem 0 1rem; }
        /* Tables */
        .dt{ width:100%; border-collapse:collapse; margin-bottom:1.5rem; }
        .dt thead tr{ background:var(--primary); color:#fff; }
        .dt thead th{ padding:.55rem .9rem; font-size:.76rem; font-weight:700; }
        .dt tbody tr{ border-bottom:1px solid #f0f4f0; }
        .dt tbody tr:nth-child(even){ background:#f9fbf9; }
        .dt tbody td{ padding:.48rem .9rem; font-size:.8rem; vertical-align:middle; }
        .dt tfoot td{ padding:.6rem .9rem; font-size:.82rem; font-weight:700; background:#e8f5e9; border-top:2px solid var(--primary); }
        .trx-table{ width:100%; border-collapse:collapse; font-size:.76rem; }
        .trx-table thead tr{ background:var(--dark); color:#fff; }
        .trx-table thead th{ padding:.5rem .7rem; font-weight:600; font-size:.72rem; }
        .trx-table tbody tr{ border-bottom:1px solid #f0f4f0; }
        .trx-table tbody tr:nth-child(even){ background:#fafafa; }
        .trx-table tbody td{ padding:.42rem .7rem; vertical-align:middle; }
        .trx-table tfoot td{ padding:.5rem .7rem; font-weight:700; background:#e8f5e9; border-top:2px solid var(--primary); font-size:.8rem; }
        /* Badge */
        .bs{ display:inline-block; padding:.15rem .5rem; border-radius:50px; font-size:.63rem; font-weight:700; }
        .bs-success{ background:#e8f5e9; color:#2d6a4f; }
        .bs-pending{ background:#fff8e1; color:#b08000; }
        .bs-failed,.bs-expired{ background:#fde8e8; color:#c62828; }
        /* Rank */
        .rk{ display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; border-radius:50%; font-size:.68rem; font-weight:800; }
        .rk-1{ background:#ffd700; color:#5a4200; }
        .rk-2{ background:#c0c0c0; color:#333; }
        .rk-3{ background:#cd7f32; color:#fff; }
        .rk-n{ background:#f0f4f0; color:#888; }
        /* Footer */
        .report-footer{ margin-top:2.5rem; padding-top:1rem; border-top:1.5px solid #e4eaf0; display:flex; justify-content:space-between; align-items:flex-end; font-size:.72rem; color:#aaa; }
        .sig-box{ text-align:center; min-width:180px; }
        .sig-line{ border-top:1.5px solid #ccc; padding-top:.4rem; margin-top:3.5rem; font-size:.75rem; color:#555; font-weight:600; }
        /* Print bar */
        .print-bar{ position:fixed; bottom:1.5rem; right:1.5rem; display:flex; gap:.75rem; z-index:999; }
        .btn-print{ background:linear-gradient(135deg,var(--primary),#2d9a56); color:#fff; border:none; padding:.72rem 1.4rem; border-radius:50px; font-family:'Poppins',sans-serif; font-weight:700; font-size:.88rem; cursor:pointer; box-shadow:0 6px 20px rgba(26,107,58,.4); transition:all .25s; }
        .btn-print:hover{ transform:translateY(-2px); }
        .btn-back{ background:#fff; color:#555; border:1.5px solid #ddd; padding:.72rem 1.2rem; border-radius:50px; font-family:'Poppins',sans-serif; font-weight:600; font-size:.88rem; cursor:pointer; transition:all .25s; }
        .btn-back:hover{ border-color:#999; color:#222; }
        @media print{
            .print-bar{ display:none !important; }
            body{ font-size:9.5pt; }
            .page-wrap{ padding:.8cm 1.2cm; max-width:100%; }
            .metrics-grid{ page-break-inside:avoid; }
            @page{ size:A4; margin:1.2cm; }
        }
    </style>
</head>
<body>

<div class="print-bar">
    <button class="btn-back" onclick="history.back()">← Kembali</button>
    <button class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
</div>

<div class="page-wrap">

    {{-- HEADER --}}
    <div class="report-header">
        <div>
            <div class="brand-name">▲ Mountain<span>Trip</span></div>
            <div class="brand-sub">
                Platform Open Trip Pendakian Gunung Indonesia<br>
                info@mountaintrip.id · Yogyakarta, Indonesia
            </div>
        </div>
        <div class="report-title-right">
            <h2>Laporan Keuangan Bulanan</h2>
            <div class="period">Periode: {{ $months[$month] }} {{ $year }}</div>
            <div class="generated">Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>

    {{-- METRICS --}}
    <div class="metrics-grid">
        <div class="metric-box highlight">
            <div class="m-label">Total Pendapatan</div>
            <div class="m-value">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</div>
            <div class="m-sub">Dari transaksi sukses bulan ini</div>
        </div>
        <div class="metric-box">
            <div class="m-label">Total Transaksi</div>
            <div class="m-value">{{ number_format($summary->total_transactions ?? 0) }}</div>
            <div class="m-sub">Semua status</div>
        </div>
        <div class="metric-box">
            <div class="m-label">Transaksi Sukses</div>
            <div class="m-value" style="color:#1a6b3a;">{{ number_format($summary->total_success ?? 0) }}</div>
            <div class="m-sub">Pembayaran berhasil</div>
        </div>
        <div class="metric-box">
            <div class="m-label">Total Peserta</div>
            <div class="m-value">{{ number_format($summary->total_participants ?? 0) }}</div>
            <div class="m-sub">Orang berhasil terdaftar</div>
        </div>
        <div class="metric-box">
            <div class="m-label">Gagal / Expired</div>
            <div class="m-value" style="color:#c62828;">{{ number_format($summary->total_failed ?? 0) }}</div>
            <div class="m-sub">Tidak berhasil bayar</div>
        </div>
        <div class="metric-box">
            <div class="m-label">Success Rate</div>
            <div class="m-value">
                {{ $summary->total_transactions > 0 ? round(($summary->total_success / $summary->total_transactions)*100,1) : 0 }}%
            </div>
            <div class="m-sub">Konversi pembayaran</div>
        </div>
    </div>

    {{-- PER GUNUNG --}}
    <div class="section-heading">Performa per Gunung</div>
    @if($perMountain->count())
    <table class="dt">
        <thead>
            <tr>
                <th style="width:32px; text-align:center;">#</th>
                <th>Nama Gunung</th>
                <th>Lokasi</th>
                <th style="text-align:center;">Transaksi</th>
                <th style="text-align:center;">Peserta</th>
                <th style="text-align:right;">Pendapatan</th>
                <th style="text-align:center;">Kontribusi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perMountain as $i => $mt)
            <tr>
                <td style="text-align:center;">
                    <span class="rk {{ $i===0?'rk-1':($i===1?'rk-2':($i===2?'rk-3':'rk-n')) }}">{{ $i+1 }}</span>
                </td>
                <td><strong>{{ $mt->mountain->name }}</strong></td>
                <td style="color:#888;">{{ $mt->mountain->location ?? '-' }}</td>
                <td style="text-align:center;">{{ $mt->total_orders }}</td>
                <td style="text-align:center;">{{ $mt->total_participants }}</td>
                <td style="text-align:right; font-weight:700; color:#1a6b3a;">
                    Rp {{ number_format($mt->total_revenue, 0, ',', '.') }}
                </td>
                <td style="text-align:center; color:#888;">
                    {{ ($summary->total_revenue ?? 0) > 0 ? round(($mt->total_revenue / $summary->total_revenue)*100,1) : 0 }}%
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Jumlah Total</td>
                <td style="text-align:center;">{{ $perMountain->sum('total_participants') }}</td>
                <td style="text-align:right; color:#1a6b3a;">Rp {{ number_format($summary->total_revenue??0,0,',','.') }}</td>
                <td style="text-align:center;">100%</td>
            </tr>
        </tfoot>
    </table>
    @else
    <p style="color:#aaa; font-size:.85rem; padding:1rem 0;">Tidak ada data gunung untuk periode ini.</p>
    @endif

    {{-- DETAIL TRANSAKSI --}}
    <div class="section-heading">Detail Transaksi Lengkap</div>
    @if($transactions->count())
    <table class="trx-table">
        <thead>
            <tr>
                <th style="width:26px; text-align:center;">#</th>
                <th>Tanggal</th>
                <th>Order ID</th>
                <th>Nama Peserta</th>
                <th>Gunung</th>
                <th style="text-align:center;">Pax</th>
                <th style="text-align:right;">Total</th>
                <th style="text-align:center;">Status</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $trx)
            <tr>
                <td style="text-align:center; color:#aaa;">{{ $i+1 }}</td>
                <td>{{ $trx->created_at->format('d/m/y') }}<br>
                    <span style="font-size:.65rem; color:#bbb;">{{ $trx->created_at->format('H:i') }}</span>
                </td>
                <td style="font-family:monospace; font-size:.65rem; color:#999;">{{ $trx->order_id }}</td>
                <td><strong>{{ $trx->full_name }}</strong><br>
                    <span style="font-size:.65rem; color:#aaa;">{{ $trx->no_wa }}</span>
                </td>
                <td>{{ $trx->mountain->name }}</td>
                <td style="text-align:center;">{{ $trx->participant_count }}</td>
                <td style="text-align:right; font-weight:700; color:{{ $trx->status==='success'?'#1a6b3a':'#aaa' }};">
                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                </td>
                <td style="text-align:center;">
                    <span class="bs bs-{{ $trx->status }}">{{ $trx->status_label }}</span>
                </td>
                <td style="color:#aaa; font-size:.68rem;">{{ $trx->payment_type ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total Pendapatan — {{ $months[$month] }} {{ $year }}</td>
                <td style="text-align:center;">{{ $transactions->sum('participant_count') }}</td>
                <td style="text-align:right; color:#1a6b3a;">Rp {{ number_format($summary->total_revenue??0,0,',','.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    @else
    <p style="color:#aaa; font-size:.85rem;">Tidak ada transaksi untuk periode ini.</p>
    @endif

    {{-- FOOTER --}}
    <div class="report-footer">
        <div>
            <div>MountainTrip — Laporan Bulanan {{ $months[$month] }} {{ $year }}</div>
            <div>Dicetak otomatis oleh sistem pada {{ now()->format('d M Y H:i') }} WIB</div>
            <div style="margin-top:.3rem;">Dokumen ini valid tanpa tanda tangan basah.</div>
        </div>
        <div class="sig-box">
            <div class="sig-line">
                Mengetahui,<br>Admin MountainTrip
                <br><span style="font-size:.65rem; color:#aaa; font-weight:400;">Pengelola Sistem</span>
            </div>
        </div>
    </div>

</div>
</body>
</html>