{{-- ══════════════════════════════════════════════════════════
     FILE: resources/views/admin/users/index.blade.php
══════════════════════════════════════════════════════════ --}}
@extends('layouts.admin')
@section('title','Manajemen Pengguna')
@section('page-title','Manajemen Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item active">Semua Pengguna</li>
@endsection

@section('content')

{{-- Stats --}}
<div class="row g-3 mb-4">
    @foreach([
        ['label'=>'Total Pengguna','value'=>$stats['total'], 'icon'=>'people-fill',    'color'=>'primary'],
        ['label'=>'Admin',         'value'=>$stats['admin'], 'icon'=>'shield-fill',     'color'=>'danger'],
        ['label'=>'User',          'value'=>$stats['user'],  'icon'=>'person-fill',     'color'=>'success'],
    ] as $s)
    <div class="col-md-4">
        <div class="stat-card bg-white">
            <div class="stat-icon bg-{{ $s['color'] }} bg-opacity-10">
                <i class="bi bi-{{ $s['icon'] }} text-{{ $s['color'] }} fs-4"></i>
            </div>
            <div>
                <div class="stat-value">{{ number_format($s['value']) }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filter + Tambah --}}
<div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold small">Cari Pengguna</label>
                <input type="text" name="search" class="form-control rounded-3"
                       placeholder="Nama atau email..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Filter Role</label>
                <select name="role" class="form-select rounded-3">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected':'' }}>Admin</option>
                    <option value="user"  {{ request('role')=='user'  ? 'selected':'' }}>User</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success rounded-3 w-100">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
            </div>
            <div class="col-md-2 text-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-3 w-100">
                    <i class="bi bi-plus-lg me-1"></i>Tambah
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 small fw-semibold text-muted" style="width:50px">#</th>
                        <th class="small fw-semibold text-muted">Pengguna</th>
                        <th class="small fw-semibold text-muted">Role</th>
                        <th class="small fw-semibold text-muted text-center">Transaksi</th>
                        <th class="small fw-semibold text-muted text-center">Ulasan</th>
                        <th class="small fw-semibold text-muted">Bergabung</th>
                        <th class="small fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                     style="width:38px; height:38px; font-size:.9rem;
                                            background:{{ $user->role==='admin' ? 'linear-gradient(135deg,#dc3545,#e07080)' : 'linear-gradient(135deg,#1a6b3a,#2d9a56)' }};">
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold small">{{ $user->name }}
                                        @if($user->id === auth()->id())
                                        <span class="badge bg-warning text-dark rounded-pill ms-1" style="font-size:.6rem;">Anda</span>
                                        @endif
                                    </div>
                                    <div class="text-muted" style="font-size:.75rem;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-semibold
                                {{ $user->role==='admin' ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }}">
                                <i class="bi bi-{{ $user->role==='admin' ? 'shield-fill' : 'person-fill' }} me-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border rounded-pill px-3">
                                {{ $user->transactions_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border rounded-pill px-3">
                                {{ $user->reviews_count }}
                            </span>
                        </td>
                        <td class="text-muted small">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-outline-info rounded-3" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-sm btn-outline-primary rounded-3" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus akun {{ addslashes($user->name) }}? Semua data terkait ikut terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-people display-3 d-block mb-3 opacity-25"></i>
                            Belum ada pengguna.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection