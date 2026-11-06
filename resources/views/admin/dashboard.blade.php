@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- STAT CARDS --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1a6b3a,#2d9a56); color:#fff;">
            <div class="stat-icon" style="background:rgba(255,255,255,.2);">
                <i class="bi bi-receipt text-white"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_transactions']) }}</div>
                <div class="stat-label" style="color:rgba(255,255,255,.8);">Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background:#fff;">
            <div class="stat-icon bg-warning bg-opacity-10">
                <i class="bi bi-people text-warning fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['total_participants']) }}</div>
                <div class="stat-label">Total Peserta</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background:#fff;">
            <div class="stat-icon bg-success bg-opacity-10">
                <i class="bi bi-currency-dollar text-success fs-4"></i>
            </div>
            <div>
                <div class="stat-value" style="font-size:1.3rem;">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background:#fff;">
            <div class="stat-icon bg-danger bg-opacity-10">
                <i class="bi bi-hourglass text-danger fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($stats['pending_count']) }}</div>
                <div class="stat-label">Transaksi Pending</div>
            </div>
        </div>
    </div>
</div>

{{-- RECENT TRANSACTIONS --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt text-success me-2"></i>Transaksi Terbaru</h6>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-success rounded-pill">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 small fw-semibold text-muted">Peserta</th>
                                <th class="small fw-semibold text-muted">Gunung</th>
                                <th class="small fw-semibold text-muted">Total</th>
                                <th class="small fw-semibold text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_transactions as $trx)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold small">{{ $trx->full_name }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">{{ $trx->no_wa }}</div>
                                </td>
                                <td class="small">{{ $trx->mountain->name }}</td>
                                <td class="small fw-semibold">{{ $trx->formatted_total_price }}</td>
                                <td>
                                    <span class="badge bg-{{ $trx->status_badge }} rounded-pill px-3">
                                        {{ $trx->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="bi bi-fire text-warning me-2"></i>Gunung Terpopuler</h6>
            </div>
            <div class="card-body">
                @forelse($popular_mountains as $i => $mountain)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="fw-bold text-muted" style="width:20px;">{{ $i + 1 }}.</div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $mountain->name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ $mountain->transactions_count }} pesanan</div>
                    </div>
                    <span class="badge bg-success-subtle text-success rounded-pill">
                        {{ $mountain->formatted_price }}
                    </span>
                </div>
                @empty
                <p class="text-muted small">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection