@extends('layouts.admin')
@section('title','Laporan Bulanan')
@section('page-title','Laporan Bulanan')
@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@push('styles')
<style>
    .report-card {
        background:#fff; border:none; border-radius:20px;
        box-shadow:0 4px 20px rgba(0,0,0,.06); padding:1.5rem;
    }
    .metric-card {
        border-radius:16px; padding:1.4rem;
        display:flex; align-items:center; gap:1rem;
    }
    .metric-icon {
        width:52px; height:52px; border-radius:12px;
        display:flex; align-items:center; justify-content:center;
        font-size:1.4rem; flex-shrink:0;
    }
    .metric-value { font-size:1.7rem; font-weight:800; line-height:1; color:#0d1b2a; }
    .metric-label { font-size:.78rem; color:#888; margin-top:.2rem; }
    .metric-growth {
        font-size:.72rem; font-weight:700; padding:.2rem .5rem;
        border-radius:50px; margin-left:.5rem;
    }
    .growth-up   { background:#e8f5e9; color:#2d9a56; }
    .growth-down { background:#fde8e8; color:#dc3545; }
    .mountain-rank-item {
        display:flex; align-items:center; gap:.75rem;
        padding:.65rem 0; border-bottom:1px solid #f4f6f8;
    }
    .mountain-rank-item:last-child { border-bottom:none; }
    .rank-num {
        width:28px; height:28px; border-radius:50%;
        display:flex; align-items:center; justify-content:center;
        font-size:.75rem; font-weight:800; flex-shrink:0;
    }
</style>
@endpush

@section('content')

{{-- Filter Bar --}}
<div class="report-card mb-4">
    <form action="{{ route('admin.reports.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Bulan</label>
                <select name="month" class="form-select rounded-3">
                    @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                               7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $m=>$n)
                    <option value="{{ $m }}" {{ $month==$m ? 'selected':'' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold small">Tahun</label>
                <select name="year" class="form-select rounded-3">
                    @foreach($availableYears as $y)
                    <option value="{{ $y }}" {{ $year==$y ? 'selected':'' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Tampilkan
                </button>
            </div>
            <div class="col-md-5 text-end">
                <a href="{{ route('admin.reports.print', ['month'=>$month,'year'=>$year]) }}"
                   target="_blank"
                   class="btn btn-outline-primary rounded-3">
                    <i class="bi bi-printer me-2"></i>Cetak / Export PDF
                </a>
            </div>
        </div>
    </form>
</div>

@php
    $monthNames = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
@endphp

<h5 class="fw-bold mb-4 text-muted">
    Periode: <span class="text-dark">{{ $monthNames[$month] }} {{ $year }}</span>
</h5>

{{-- Metric Cards --}}
<div class="row g-3 mb-4">
    {{-- Total Revenue --}}
    <div class="col-md-6 col-xl-3">
        <div class="metric-card" style="background:linear-gradient(135deg,#1a6b3a,#2d9a56); color:#fff;">
            <div class="metric-icon" style="background:rgba(255,255,255,.2);">
                <i class="bi bi-currency-dollar text-white"></i>
            </div>
            <div>
                <div class="metric-value" style="color:#fff; font-size:1.3rem;">
                    Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                </div>
                <div class="metric-label" style="color:rgba(255,255,255,.75);">
                    Total Pendapatan
                    @if($revenueGrowth != 0)
                    <span class="metric-growth {{ $revenueGrowth>0 ? 'growth-up':'growth-down' }}" style="background:rgba(255,255,255,.2); color:#fff;">
                        {{ $revenueGrowth>0 ? '▲' : '▼' }} {{ abs($revenueGrowth) }}%
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Total Transaksi --}}
    <div class="col-md-6 col-xl-3">
        <div class="metric-card bg-white">
            <div class="metric-icon bg-primary bg-opacity-10">
                <i class="bi bi-receipt text-primary fs-3"></i>
            </div>
            <div>
                <div class="metric-value">{{ number_format($summary->total_transactions ?? 0) }}</div>
                <div class="metric-label">Total Transaksi</div>
            </div>
        </div>
    </div>
    {{-- Sukses --}}
    <div class="col-md-6 col-xl-3">
        <div class="metric-card bg-white">
            <div class="metric-icon bg-success bg-opacity-10">
                <i class="bi bi-check-circle text-success fs-3"></i>
            </div>
            <div>
                <div class="metric-value">{{ number_format($summary->total_success ?? 0) }}</div>
                <div class="metric-label">Transaksi Sukses</div>
            </div>
        </div>
    </div>
    {{-- Total Peserta --}}
    <div class="col-md-6 col-xl-3">
        <div class="metric-card bg-white">
            <div class="metric-icon bg-warning bg-opacity-10">
                <i class="bi bi-people text-warning fs-3"></i>
            </div>
            <div>
                <div class="metric-value">{{ number_format($summary->total_participants ?? 0) }}</div>
                <div class="metric-label">Total Peserta</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">

    {{-- Revenue Chart --}}
    <div class="col-lg-8">
        <div class="report-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-graph-up text-success me-2"></i>Pendapatan Harian
                </h6>
                <span class="badge bg-success-subtle text-success rounded-pill px-3">
                    {{ $monthNames[$month] }} {{ $year }}
                </span>
            </div>
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>

    {{-- Top Mountains --}}
    <div class="col-lg-4">
        <div class="report-card h-100">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-trophy text-warning me-2"></i>Gunung Terlaris
            </h6>
            @forelse($perMountain as $i => $mt)
            <div class="mountain-rank-item">
                <div class="rank-num"
                     style="background:{{ $i===0 ? '#ffd700' : ($i===1 ? '#c0c0c0' : ($i===2 ? '#cd7f32' : '#f0f4f0')) }};
                            color:{{ $i<=2 ? '#333' : '#888' }};">
                    {{ $i+1 }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold small">{{ $mt->mountain->name }}</div>
                    <div class="text-muted" style="font-size:.72rem;">
                        {{ $mt->total_participants }} peserta · {{ $mt->total_orders }} transaksi
                    </div>
                </div>
                <div class="text-success fw-bold small">
                    Rp {{ number_format($mt->total_revenue/1000000,1) }}jt
                </div>
            </div>
            @empty
            <p class="text-muted small">Belum ada data.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- Transaction Detail Table --}}
<div class="report-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-table text-success me-2"></i>
            Detail Transaksi ({{ count($transactions) }} total)
        </h6>
        <div class="d-flex gap-2">
            <span class="badge bg-success-subtle text-success rounded-pill">
                Sukses: {{ $summary->total_success ?? 0 }}
            </span>
            <span class="badge bg-warning-subtle text-warning rounded-pill">
                Pending: {{ $summary->total_pending ?? 0 }}
            </span>
            <span class="badge bg-danger-subtle text-danger rounded-pill">
                Gagal/Expired: {{ $summary->total_failed ?? 0 }}
            </span>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Tanggal</th>
                    <th>Order ID</th>
                    <th>Peserta</th>
                    <th>Gunung</th>
                    <th class="text-center">Jml</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td class="ps-3 text-muted">{{ $trx->created_at->format('d M') }}</td>
                    <td><code style="font-size:.7rem;">{{ $trx->order_id }}</code></td>
                    <td class="fw-semibold">{{ $trx->full_name }}</td>
                    <td>{{ $trx->mountain->name }}</td>
                    <td class="text-center">{{ $trx->participant_count }}</td>
                    <td class="text-end fw-bold text-success">
                        Rp {{ number_format($trx->total_price,0,',','.') }}
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ $trx->status_badge }}-subtle text-{{ $trx->status_badge }} rounded-pill">
                            {{ $trx->status_label }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada transaksi bulan ini.</td></tr>
                @endforelse
            </tbody>
            @if($transactions->count())
            <tfoot class="table-light">
                <tr>
                    <td colspan="5" class="ps-3 fw-bold">Total Pendapatan (Sukses)</td>
                    <td class="text-end fw-bold text-success">
                        Rp {{ number_format($summary->total_revenue ?? 0,0,',','.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const ctx    = document.getElementById('revenueChart').getContext('2d');
    const labels = {!! json_encode($chartLabels) !!};
    const revenue= {!! json_encode($chartRevenue) !!};
    const orders = {!! json_encode($chartOrders) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(d => d + ' {{ $monthNames[$month] }}'),
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: revenue,
                    backgroundColor: 'rgba(45,154,86,.75)',
                    borderRadius: 6,
                    yAxisID: 'y',
                },
                {
                    label: 'Jumlah Transaksi',
                    data: orders,
                    type: 'line',
                    borderColor: '#ff6b35',
                    backgroundColor: 'rgba(255,107,53,.12)',
                    tension: .4, pointRadius: 3,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            interaction: { mode:'index', intersect:false },
            scales: {
                y:  { type:'linear', display:true, position:'left',
                       ticks:{ callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'jt' } },
                y1: { type:'linear', display:true, position:'right',
                       grid:{ drawOnChartArea:false }, ticks:{ stepSize:1 } }
            },
            plugins: { legend:{ position:'top' } }
        }
    });
})();
</script>
@endpush