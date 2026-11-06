@extends('layouts.admin')
@section('title', 'Manajemen Transaksi')
@section('page-title', 'Manajemen Transaksi')
@section('breadcrumb')
    <li class="breadcrumb-item active">Semua Transaksi</li>
@endsection

@section('content')

{{-- Filter Bar --}}
<div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.transactions.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold small">Cari Peserta / Order ID</label>
                <input type="text" name="search" class="form-control rounded-3"
                       placeholder="Nama, Order ID, atau No. WA..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Filter Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="">Semua Status</option>
                    @foreach(['pending','success','failed','expired'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-success rounded-3 flex-grow-1">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                @if(request()->hasAny(['search','status','mountain_id']))
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary rounded-3">
                    <i class="bi bi-x-lg"></i>
                </a>
                @endif
            </div>
            <div class="col-md-2 text-end">
                <span class="text-muted small">
                    Total: <strong>{{ $transactions->total() }}</strong>
                </span>
            </div>
        </div>
    </form>
</div>

{{-- Stats row --}}
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Semua',  'status'=>'',        'icon'=>'receipt',           'color'=>'secondary'],
        ['label'=>'Sukses', 'status'=>'success',  'icon'=>'check-circle',      'color'=>'success'],
        ['label'=>'Pending','status'=>'pending',  'icon'=>'hourglass-split',   'color'=>'warning'],
        ['label'=>'Gagal',  'status'=>'failed',   'icon'=>'x-circle',          'color'=>'danger'],
    ] as $stat)
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.transactions.index', ['status' => $stat['status']]) }}"
           class="card border-0 rounded-4 shadow-sm p-3 text-decoration-none d-block
                  {{ request('status') == $stat['status'] ? 'border border-'.$stat['color'] : '' }}"
           style="transition:all .2s;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-{{ $stat['icon'] }} text-{{ $stat['color'] }}"></i>
                <span class="small fw-semibold text-dark">{{ $stat['label'] }}</span>
            </div>
        </a>
    </div>
    @endforeach
</div>

{{-- Tabel Transaksi --}}
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 small fw-semibold text-muted">Order ID</th>
                        <th class="small fw-semibold text-muted">Peserta</th>
                        <th class="small fw-semibold text-muted">Gunung</th>
                        <th class="small fw-semibold text-muted">Total</th>
                        <th class="small fw-semibold text-muted">Tanggal</th>
                        <th class="small fw-semibold text-muted">Status</th>
                        <th class="small fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="ps-4">
                            <code style="font-size:.75rem;">{{ $trx->order_id }}</code>
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ $trx->full_name }}</div>
                            <div class="text-muted" style="font-size:.72rem;">
                                <i class="bi bi-whatsapp me-1 text-success"></i>{{ $trx->no_wa }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                {{ $trx->participant_count }} peserta · {{ $trx->age }} thn
                            </div>
                        </td>
                        <td class="small">{{ $trx->mountain->name }}</td>
                        <td>
                            <div class="fw-bold small text-success">{{ $trx->formatted_total_price }}</div>
                            @if($trx->payment_type)
                            <div class="text-muted" style="font-size:.72rem;">{{ $trx->payment_type }}</div>
                            @endif
                        </td>
                        <td class="small text-muted">
                            {{ $trx->created_at->format('d M Y') }}<br>
                            <span style="font-size:.72rem;">{{ $trx->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $trx->status_badge }}-subtle text-{{ $trx->status_badge }}
                                         rounded-pill px-3 py-1 fw-semibold">
                                {{ $trx->status_label }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.transactions.show', $trx) }}"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-receipt display-3 d-block mb-3 opacity-25"></i>
                            Tidak ada transaksi ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $transactions->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection