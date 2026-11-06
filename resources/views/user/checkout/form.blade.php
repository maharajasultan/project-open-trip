@extends('layouts.app')
@section('title', 'Checkout - ' . $mountain->name)

@section('content')
<div style="padding-top:90px; padding-bottom:3rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Breadcrumb --}}
                <nav class="mb-4" data-aos="fade-down">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('mountains.show', $mountain) }}" class="text-success">{{ $mountain->name }}</a>
                        </li>
                        <li class="breadcrumb-item active">Data Diri Peserta</li>
                    </ol>
                </nav>

                <h2 class="fw-bold mb-1" data-aos="fade-up" style="font-family:'Montserrat',sans-serif;">
                    <i class="bi bi-person-badge text-success me-2"></i>Data Diri Peserta
                </h2>
                <p class="text-muted mb-4" data-aos="fade-up" data-aos-delay="50">
                    Isi data dengan benar. Data ini akan digunakan untuk keperluan pendakian dan WhatsApp Group.
                </p>

                <div class="row g-4">
                    {{-- FORM --}}
                    <div class="col-lg-8">
                        <div class="card border-0 rounded-4 shadow-sm p-4" data-aos="fade-up" data-aos-delay="100">
                            <form action="{{ route('checkout.process', $mountain) }}" method="POST" id="checkoutForm">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-person me-1 text-success"></i>Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="full_name" class="form-control rounded-3 @error('full_name') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap sesuai KTP"
                                           value="{{ old('full_name', Auth::user()->name) }}" required>
                                    @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold small">
                                            <i class="bi bi-calendar2 me-1 text-success"></i>Umur <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="age" min="10" max="99"
                                               class="form-control rounded-3 @error('age') is-invalid @enderror"
                                               placeholder="Tahun" value="{{ old('age') }}" required>
                                        @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-semibold small">
                                            <i class="bi bi-whatsapp me-1 text-success"></i>No. WhatsApp Aktif <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="no_wa"
                                               class="form-control rounded-3 @error('no_wa') is-invalid @enderror"
                                               placeholder="Contoh: 08123456789" value="{{ old('no_wa') }}" required>
                                        @error('no_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-envelope me-1 text-success"></i>Email Aktif <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email"
                                           class="form-control rounded-3 @error('email') is-invalid @enderror"
                                           placeholder="email@contoh.com"
                                           value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-geo-alt me-1 text-success"></i>Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="address" rows="3"
                                              class="form-control rounded-3 @error('address') is-invalid @enderror"
                                              placeholder="Masukkan alamat lengkap..." required>{{ old('address') }}</textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">
                                        <i class="bi bi-people me-1 text-success"></i>Jumlah Peserta <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="participant_count" id="participantCount"
                                           min="1" max="{{ $mountain->available_quota }}"
                                           class="form-control rounded-3 @error('participant_count') is-invalid @enderror"
                                           placeholder="Berapa peserta?" value="{{ old('participant_count', 1) }}" required>
                                    <div class="form-text">
                                        Kuota tersedia: <strong>{{ $mountain->available_quota }}</strong> orang
                                    </div>
                                    @error('participant_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Kalkulasi Harga Real-time --}}
                                <div class="p-4 rounded-4 mb-4" style="background: linear-gradient(135deg, #e8f5e9, #f1f8e9);">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small">Harga Per Orang:</span>
                                        <strong>{{ $mountain->formatted_price }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted small">Jumlah Peserta:</span>
                                        <strong id="displayCount">1 orang</strong>
                                    </div>
                                    <hr style="border-color: rgba(26,107,58,.2);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Total Pembayaran:</span>
                                        <span class="fw-bold fs-4" style="color:var(--primary);" id="totalPrice">
                                            {{ $mountain->formatted_price }}
                                        </span>
                                    </div>
                                </div>

                                <div class="alert alert-info border-0 rounded-3 small">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Setelah submit, Anda akan diarahkan ke halaman pembayaran Midtrans.
                                </div>

                                <button type="submit" class="btn btn-secondary-custom w-100 py-3 fw-bold fs-6">
                                    <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- TRIP SUMMARY --}}
                    <div class="col-lg-4">
                        <div class="card border-0 rounded-4 shadow-sm overflow-hidden" data-aos="fade-left" data-aos-delay="150">
                            <img src="{{ $mountain->image_url }}" alt="{{ $mountain->name }}" style="height:160px; object-fit:cover;">
                            <div class="card-body p-4">
                                <h6 class="fw-bold">{{ $mountain->name }}</h6>
                                <p class="text-muted small mb-3">{{ $mountain->location }}</p>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted"><i class="bi bi-calendar3 me-1"></i>Tanggal</span>
                                        <strong>{{ $mountain->departure_date->format('d M Y') }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted"><i class="bi bi-people me-1"></i>Sisa Kuota</span>
                                        <strong>{{ $mountain->available_quota }} slot</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const pricePerPerson = Number('{{ $mountain->price }}');
    const participantInput = document.getElementById('participantCount');
    const totalPriceEl    = document.getElementById('totalPrice');
    const displayCountEl  = document.getElementById('displayCount');

    function updatePrice() {
        const count     = parseInt(participantInput.value) || 1;
        const total     = count * pricePerPerson;
        const formatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        totalPriceEl.textContent   = formatted;
        displayCountEl.textContent = count + ' orang';
    }

    participantInput.addEventListener('input', updatePrice);
    updatePrice();
</script>
@endpush