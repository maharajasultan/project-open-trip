@extends('layouts.admin')
@section('title', 'Detail: ' . $mountain->name)
@section('page-title', 'Detail Gunung')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mountains.index') }}">Gunung</a></li>
    <li class="breadcrumb-item active">{{ $mountain->name }}</li>
@endsection

@section('content')

<div class="row g-4 mb-4">
    {{-- Info Utama --}}
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
            <div class="position-relative" style="height:250px;">
                <img src="{{ $mountain->image_url }}" alt="{{ $mountain->name }}"
                     style="width:100%; height:100%; object-fit:cover;">
                <div style="position:absolute; inset:0;
                     background:linear-gradient(to top,rgba(13,27,42,.8) 0%,transparent 60%);">
                </div>
                <div class="position-absolute bottom-0 start-0 p-4">
                    <h3 class="text-white fw-bold mb-1">{{ $mountain->name }}</h3>
                    <span class="badge bg-{{ $mountain->difficulty_badge }} rounded-pill px-3">
                        {{ $mountain->difficulty ?? 'Open Trip' }}
                    </span>
                    <span class="badge bg-{{ $mountain->is_active ? 'success' : 'secondary' }} rounded-pill px-3 ms-1">
                        {{ $mountain->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6 text-center p-3 bg-light rounded-3">
                        <div class="fw-bold fs-5 text-success">{{ $mountain->formatted_price }}</div>
                        <div class="text-muted small">Per Orang</div>
                    </div>
                    <div class="col-md-3 col-6 text-center p-3 bg-light rounded-3">
                        <div class="fw-bold fs-5">{{ $mountain->departure_date->format('d M Y') }}</div>
                        <div class="text-muted small">Keberangkatan</div>
                    </div>
                    <div class="col-md-3 col-6 text-center p-3 bg-light rounded-3">
                        <div class="fw-bold fs-5">{{ $mountain->registered_count }}/{{ $mountain->quota }}</div>
                        <div class="text-muted small">Kuota Terisi</div>
                    </div>
                    <div class="col-md-3 col-6 text-center p-3 bg-light rounded-3">
                        <div class="fw-bold fs-5">{{ $mountain->altitude ? number_format($mountain->altitude).' mdpl' : '-' }}</div>
                        <div class="text-muted small">Ketinggian</div>
                    </div>
                </div>

                {{-- Progress kuota --}}
                @php $pct = $mountain->quota > 0 ? ($mountain->registered_count / $mountain->quota) * 100 : 0; @endphp
                <div class="mb-4">
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Kapasitas Terisi</span>
                        <span class="fw-semibold">{{ round($pct) }}%</span>
                    </div>
                    <div class="progress" style="height:8px; border-radius:10px;">
                        <div class="progress-bar bg-{{ $pct >= 80 ? 'danger' : ($pct >= 50 ? 'warning' : 'success') }}"style="width:{{ $pct }}%;"></div>
                    </div>
                </div>

                <h6 class="fw-bold mb-2">Deskripsi</h6>
                <p class="text-muted" style="line-height:1.8;">{{ $mountain->description }}</p>

                <h6 class="fw-bold mb-2 mt-4">Itinerary</h6>
                <div class="p-3 bg-light rounded-3 font-monospace small text-muted"
                     style="white-space:pre-line; line-height:1.8; max-height:250px; overflow-y:auto;">{{ $mountain->itinerary }}</div>
            </div>
        </div>
    </div>

    {{-- Sidebar aksi --}}
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3">Aksi Cepat</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.mountains.edit', $mountain) }}"
                   class="btn btn-outline-primary rounded-3">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Gunung
                </a>
                <a href="{{ route('admin.transactions.index', ['mountain_id' => $mountain->id]) }}"
                   class="btn btn-outline-success rounded-3">
                    <i class="bi bi-receipt me-2"></i>Lihat Semua Transaksi
                </a>
                <form action="{{ route('admin.mountains.destroy', $mountain) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus gunung ini? Semua transaksi terkait juga akan dihapus!')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger rounded-3 w-100">
                        <i class="bi bi-trash3 me-2"></i>Hapus Gunung
                    </button>
                </form>
            </div>
        </div>

        <div class="card border-0 rounded-4 shadow-sm p-4">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-whatsapp text-success me-2"></i>Undang Peserta ke Grup WA
            </h6>
            <p class="text-muted small mb-3">
                Klik tombol di bawah untuk membuka chat WA secara massal (salin nomor satu per satu).
            </p>
            @forelse($mountain->transactions->where('status','success') as $trx)
            <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded-3">
                <div>
                    <div class="small fw-semibold">{{ $trx->full_name }}</div>
                    <div class="text-muted" style="font-size:.72rem;">{{ $trx->no_wa }}</div>
                </div>
                <a href="https://wa.me/{{ preg_replace('/^0/','62',$trx->no_wa) }}"
                   target="_blank" class="btn btn-sm btn-success rounded-3">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>
            @empty
            <p class="text-muted small">Belum ada peserta yang sukses bayar.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Tabel Peserta --}}
<div class="card border-0 rounded-4 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-people text-success me-2"></i>
            Daftar Peserta ({{ $mountain->transactions->count() }} transaksi)
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 small fw-semibold text-muted">#</th>
                        <th class="small fw-semibold text-muted">Nama Peserta</th>
                        <th class="small fw-semibold text-muted">Kontak</th>
                        <th class="small fw-semibold text-muted">Peserta</th>
                        <th class="small fw-semibold text-muted">Total</th>
                        <th class="small fw-semibold text-muted">Status</th>
                        <th class="small fw-semibold text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mountain->transactions->sortByDesc('created_at') as $i => $trx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-semibold small">{{ $trx->full_name }}</div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $trx->age }} tahun</div>
                        </td>
                        <td>
                            <div class="small">
                                <i class="bi bi-whatsapp me-1 text-success"></i>{{ $trx->no_wa }}
                            </div>
                            <div class="text-muted" style="font-size:.72rem;">
                                <i class="bi bi-envelope me-1"></i>{{ $trx->email }}
                            </div>
                        </td>
                        <td class="small fw-semibold text-center">{{ $trx->participant_count }}</td>
                        <td class="small fw-bold text-success">{{ $trx->formatted_total_price }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->status_badge }}-subtle
                                         text-{{ $trx->status_badge }} rounded-pill px-2 py-1 fw-semibold small">
                                {{ $trx->status_label }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $trx) }}"
                               class="btn btn-sm btn-outline-primary rounded-3">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada peserta yang mendaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.mountains.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Gunung
    </a>
</div>

@endsection