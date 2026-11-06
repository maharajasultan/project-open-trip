@extends('layouts.admin')
@section('title','Detail Pengguna')
@section('page-title','Detail Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row g-4">

    {{-- Profil --}}
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 text-center mb-4">
            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fw-bold text-white"
                 style="width:80px; height:80px; font-size:2rem;
                        background:{{ $user->role==='admin' ? 'linear-gradient(135deg,#dc3545,#e07080)' : 'linear-gradient(135deg,#1a6b3a,#2d9a56)' }};">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            <span class="badge rounded-pill px-4 py-2 fw-semibold mb-3
                {{ $user->role==='admin' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                <i class="bi bi-{{ $user->role==='admin' ? 'shield-fill' : 'person-fill' }} me-1"></i>
                {{ ucfirst($user->role) }}
            </span>
            <div class="row g-2 text-center mt-1">
                <div class="col-6">
                    <div class="p-2 bg-light rounded-3">
                        <div class="fw-bold">{{ $user->transactions->count() }}</div>
                        <div class="text-muted" style="font-size:.72rem;">Transaksi</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 bg-light rounded-3">
                        <div class="fw-bold">{{ $user->reviews->count() }}</div>
                        <div class="text-muted" style="font-size:.72rem;">Ulasan</div>
                    </div>
                </div>
            </div>
            <div class="text-muted small mt-3">
                Bergabung {{ $user->created_at->format('d M Y') }}
            </div>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary rounded-3">
                <i class="bi bi-pencil-square me-2"></i>Edit Pengguna
            </a>
            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                  onsubmit="return confirm('Hapus akun ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger rounded-3 w-100">
                    <i class="bi bi-trash3 me-2"></i>Hapus Akun
                </button>
            </form>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    {{-- Riwayat & Ulasan --}}
    <div class="col-lg-8">

        {{-- Transaksi --}}
        <div class="card border-0 rounded-4 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt text-success me-2"></i>Riwayat Transaksi</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Order ID</th>
                                <th>Gunung</th>
                                <th class="text-center">Peserta</th>
                                <th class="text-end pe-4">Total</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->transactions as $trx)
                            <tr>
                                <td class="ps-4">
                                    <code style="font-size:.7rem;">{{ $trx->order_id }}</code><br>
                                    <span class="text-muted" style="font-size:.7rem;">{{ $trx->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="fw-semibold">{{ $trx->mountain->name }}</td>
                                <td class="text-center">{{ $trx->participant_count }}</td>
                                <td class="text-end pe-4 fw-bold text-success">
                                    Rp {{ number_format($trx->total_price,0,',','.') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $trx->status_badge }}-subtle text-{{ $trx->status_badge }} rounded-pill px-2">
                                        {{ $trx->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Ulasan --}}
        <div class="card border-0 rounded-4 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                <h6 class="fw-bold mb-0"><i class="bi bi-star text-warning me-2"></i>Ulasan yang Diberikan</h6>
            </div>
            <div class="card-body">
                @forelse($user->reviews as $rev)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="fw-semibold small">{{ $rev->mountain->name }}</div>
                        <div style="color:#ffc107; font-size:.85rem;">
                            @for($i=1;$i<=5;$i++)<i class="bi bi-star{{ $i<=$rev->rating?'-fill':'' }}"></i>@endfor
                        </div>
                    </div>
                    <p class="text-muted mb-1 small" style="line-height:1.6;">"{{ $rev->comment }}"</p>
                    <span class="text-muted" style="font-size:.72rem;">{{ $rev->created_at->format('d M Y') }}</span>
                </div>
                @empty
                <p class="text-muted small text-center py-3">Belum pernah memberi ulasan.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection