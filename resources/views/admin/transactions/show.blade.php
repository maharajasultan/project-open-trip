@extends('layouts.admin')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row g-4">
    {{-- DATA PESERTA --}}
    <div class="col-lg-7">
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-person-badge text-success me-2"></i>Data Lengkap Peserta
            </h5>
            <div class="row g-3">
                <div class="col-6">
                    <div class="text-muted small">Nama Lengkap</div>
                    <div class="fw-semibold">{{ $transaction->full_name }}</div>
                </div>
                <div class="col-6">
                    <div class="text-muted small">Umur</div>
                    <div class="fw-semibold">{{ $transaction->age }} tahun</div>
                </div>
                <div class="col-6">
                    <div class="text-muted small">No. WhatsApp</div>
                    <div class="fw-semibold">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $transaction->no_wa) }}"
                           target="_blank" class="text-success text-decoration-none">
                            <i class="bi bi-whatsapp me-1"></i>{{ $transaction->no_wa }}
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-muted small">Email</div>
                    <div class="fw-semibold">{{ $transaction->email }}</div>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Alamat Lengkap</div>
                    <div class="fw-semibold">{{ $transaction->address }}</div>
                </div>
                <div class="col-6">
                    <div class="text-muted small">Jumlah Peserta</div>
                    <div class="fw-semibold">{{ $transaction->participant_count }} orang</div>
                </div>
            </div>
        </div>

        {{-- TOMBOL UNDANG WA --}}
        <div class="card border-0 rounded-4 shadow-sm p-4"
             style="background: linear-gradient(135deg, #e8f5e9, #f1f8e9); border: 1px solid #c8e6c9 !important;">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-whatsapp text-success me-2"></i>Tambahkan ke Grup WhatsApp
            </h6>
            <p class="text-muted small mb-3">
                Gunakan nomor di bawah untuk menambahkan peserta ke grup pendakian:
            </p>
            <div class="d-flex gap-2 align-items-center">
                <code class="p-2 bg-white rounded-3 flex-grow-1 text-center fs-6">
                    {{ $transaction->no_wa }}
                </code>
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $transaction->no_wa) }}?text=Halo+{{ urlencode($transaction->full_name) }}!+Selamat+datang+di+Open+Trip+{{ urlencode($transaction->mountain->name) }}.+Silahkan+bergabung+dengan+grup+WhatsApp+kami."
                   target="_blank" class="btn btn-success rounded-3">
                    <i class="bi bi-box-arrow-up-right me-1"></i>Buka WA
                </a>
            </div>
        </div>
    </div>

    {{-- DATA TRANSAKSI --}}
    <div class="col-lg-5">
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-4">
                <i class="bi bi-receipt text-success me-2"></i>Info Transaksi
            </h5>
            <div class="d-flex flex-column gap-3">
                <div>
                    <div class="text-muted small">Order ID</div>
                    <code>{{ $transaction->order_id }}</code>
                </div>
                <div>
                    <div class="text-muted small">Gunung</div>
                    <div class="fw-semibold">{{ $transaction->mountain->name }}</div>
                </div>
                <div>
                    <div class="text-muted small">Harga Per Orang</div>
                    <div class="fw-semibold">{{ $transaction->mountain->formatted_price }}</div>
                </div>
                <div>
                    <div class="text-muted small">Total Pembayaran</div>
                    <div class="fw-bold fs-5 text-success">{{ $transaction->formatted_total_price }}</div>
                </div>
                <div>
                    <div class="text-muted small">Metode Pembayaran</div>
                    <div class="fw-semibold">{{ $transaction->payment_type ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-muted small">Status</div>
                    <span class="badge bg-{{ $transaction->status_badge }} rounded-pill px-3 py-2 fw-semibold">
                        {{ $transaction->status_label }}
                    </span>
                </div>
                @if($transaction->paid_at)
                <div>
                    <div class="text-muted small">Waktu Bayar</div>
                    <div class="fw-semibold">{{ $transaction->paid_at->format('d M Y, H:i') }} WIB</div>
                </div>
                @endif
                <div>
                    <div class="text-muted small">Tanggal Pemesanan</div>
                    <div class="fw-semibold">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</div>
                </div>
            </div>
        </div>

        {{-- UPDATE STATUS --}}
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Update Status Manual</h6>
            <form action="{{ route('admin.transactions.updateStatus', $transaction) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" class="form-select rounded-3 mb-3">
                    @foreach(['pending','success','failed','expired'] as $s)
                    <option value="{{ $s }}" {{ $transaction->status === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success w-100 rounded-3">
                    <i class="bi bi-arrow-clockwise me-2"></i>Update Status
                </button>
            </form>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>
@endsection