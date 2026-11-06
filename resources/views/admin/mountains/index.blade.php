@extends('layouts.admin')
@section('title', 'Daftar Gunung')
@section('page-title', 'Manajemen Gunung')
@section('breadcrumb')
    <li class="breadcrumb-item active">Daftar Gunung</li>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0 small">Total: <strong>{{ $mountains->total() }}</strong> gunung terdaftar</p>
    </div>
    <a href="{{ route('admin.mountains.create') }}" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Gunung
    </a>
</div>

<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 small fw-semibold text-muted" style="width:60px;">#</th>
                        <th class="small fw-semibold text-muted">Nama Gunung</th>
                        <th class="small fw-semibold text-muted">Harga</th>
                        <th class="small fw-semibold text-muted">Keberangkatan</th>
                        <th class="small fw-semibold text-muted">Kuota</th>
                        <th class="small fw-semibold text-muted">Status</th>
                        <th class="small fw-semibold text-muted text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mountains as $mountain)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $mountain->image_url }}"
                                     alt="{{ $mountain->name }}"
                                     class="rounded-3"
                                     style="width:50px; height:50px; object-fit:cover;">
                                <div>
                                    <div class="fw-semibold small">{{ $mountain->name }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $mountain->location ?? '-' }}
                                        @if($mountain->altitude)
                                            · {{ number_format($mountain->altitude) }} mdpl
                                        @endif
                                    </div>
                                    @if($mountain->difficulty)
                                    <span class="badge bg-{{ $mountain->difficulty_badge }} rounded-pill px-2"
                                          style="font-size:.65rem;">
                                        {{ $mountain->difficulty }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold small text-success">{{ $mountain->formatted_price }}</div>
                            <div class="text-muted" style="font-size:.72rem;">/orang</div>
                        </td>
                        <td class="small">
                            <i class="bi bi-calendar3 me-1 text-muted"></i>
                            {{ $mountain->departure_date->format('d M Y') }}<br>
                            <span class="text-muted" style="font-size:.72rem;">
                                {{ $mountain->departure_date->format('H:i') }} WIB
                            </span>
                        </td>
                        <td>
                            @php $pct = $mountain->quota > 0 ? ($mountain->registered_count / $mountain->quota) * 100 : 0; @endphp
                            <div class="small fw-semibold mb-1">
                                {{ $mountain->registered_count }} / {{ $mountain->quota }}
                            </div>
                            <div class="progress" style="height:5px; width:80px; border-radius:10px;">
                                <div class="progress-bar bg-{{ $pct >= 80 ? 'danger' : ($pct >= 50 ? 'warning' : 'success') }}"style="width:{{ $pct }}%;"></div>
                            </div>
                        </td>
                        <td>
                            @if($mountain->is_active)
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1">
                                    <i class="bi bi-circle me-1" style="font-size:.5rem;"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.mountains.edit', $mountain) }}"
                                   class="btn btn-sm btn-outline-primary rounded-3"
                                   title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.mountains.destroy', $mountain) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus gunung ini? Semua data transaksi terkait juga akan terhapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-mountain display-3 d-block mb-3 opacity-25"></i>
                            Belum ada data gunung. <a href="{{ route('admin.mountains.create') }}">Tambah sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($mountains->hasPages())
    <div class="card-footer bg-white border-0 px-4 py-3">
        {{ $mountains->links() }}
    </div>
    @endif
</div>

@endsection