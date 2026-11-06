@extends('layouts.admin')
@section('title', 'Tambah Gunung')
@section('page-title', 'Tambah Data Gunung')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mountains.index') }}">Gunung</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')

<form action="{{ route('admin.mountains.store') }}" method="POST" enctype="multipart/form-data" id="mountainForm">
    @csrf
    <div class="row g-4">

        {{-- KOLOM KIRI: Info Utama --}}
        <div class="col-lg-8">

            {{-- Informasi Dasar --}}
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-4 pb-2 border-bottom">
                    <i class="bi bi-mountain text-success me-2"></i>Informasi Dasar
                </h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small">Nama Gunung <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control rounded-3 @error('name') is-invalid @enderror"
                               placeholder="Contoh: Gunung Rinjani"
                               value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Tingkat Kesulitan</label>
                        <select name="difficulty" class="form-select rounded-3">
                            <option value="">-- Pilih --</option>
                            @foreach(['Easy','Medium','Hard'] as $d)
                            <option value="{{ $d }}" {{ old('difficulty') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Lokasi / Provinsi</label>
                        <input type="text" name="location"
                               class="form-control rounded-3 @error('location') is-invalid @enderror"
                               placeholder="Contoh: Lombok, NTB"
                               value="{{ old('location') }}">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Ketinggian (mdpl)</label>
                        <input type="number" name="altitude"
                               class="form-control rounded-3 @error('altitude') is-invalid @enderror"
                               placeholder="Contoh: 3726"
                               value="{{ old('altitude') }}">
                        @error('altitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Harga Per Orang (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-3 bg-light border-end-0 fw-semibold small text-muted">Rp</span>
                            <input type="number" name="price" min="0" step="1000"
                                   class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                                   placeholder="Contoh: 850000"
                                   value="{{ old('price') }}" required>
                        </div>
                        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Kuota Peserta <span class="text-danger">*</span></label>
                        <input type="number" name="quota" min="1"
                               class="form-control rounded-3 @error('quota') is-invalid @enderror"
                               placeholder="Contoh: 20"
                               value="{{ old('quota') }}" required>
                        @error('quota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Tanggal & Waktu Keberangkatan <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="departure_date"
                               class="form-control rounded-3 @error('departure_date') is-invalid @enderror"
                               value="{{ old('departure_date') }}" required>
                        @error('departure_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-file-text text-success me-2"></i>Deskripsi Trip
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Deskripsi Singkat <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4"
                              class="form-control rounded-3 @error('description') is-invalid @enderror"
                              placeholder="Ceritakan tentang gunung ini, keunikannya, dan hal yang bisa dinikmati peserta...">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Itinerary --}}
            <div class="card border-0 rounded-4 shadow-sm p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-map text-success me-2"></i>Itinerary Perjalanan <span class="text-danger">*</span>
                </h6>
                <p class="text-muted small mb-3">
                    Tuliskan jadwal perjalanan hari per hari. Gunakan format: <code>Hari 1: ...</code>, <code>Hari 2: ...</code>
                </p>
                <textarea name="itinerary" rows="10"
                          class="form-control rounded-3 font-monospace @error('itinerary') is-invalid @enderror"
                          style="font-size:.85rem; line-height:1.7;"
                          placeholder="Hari 1: Meeting point di Basecamp Sembalun (1156 mdpl). Briefing perjalanan, pengecekan perlengkapan, makan malam bersama.&#10;&#10;Hari 2: Start pendakian pukul 05.00 WIB. Melewati Pos 1, 2, 3 menuju Plawangan Sembalun (2900 mdpl).&#10;&#10;Hari 3: Summit Attack pukul 01.00 WIB. Tiba di puncak Rinjani 3726 mdpl menyambut sunrise.">{{ old('itinerary') }}</textarea>
                @error('itinerary') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- KOLOM KANAN: Gambar & Setting --}}
        <div class="col-lg-4">

            {{-- Upload Gambar --}}
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-image text-success me-2"></i>Foto Gunung
                </h6>
                <div class="border-2 border-dashed rounded-4 p-4 text-center mb-3"
                     style="border: 2px dashed var(--bs-border-color); cursor:pointer;"
                     id="dropZone" onclick="document.getElementById('imageInput').click()">
                    <div id="previewWrapper">
                        <i class="bi bi-cloud-upload display-4 text-muted mb-2"></i>
                        <p class="text-muted small mb-1">Klik untuk upload gambar</p>
                        <p class="text-muted" style="font-size:.72rem;">JPG, PNG, WEBP — Maks. 2MB</p>
                    </div>
                    <img id="imagePreview" src="" alt="Preview"
                         class="img-fluid rounded-3 d-none" style="max-height:200px; object-fit:cover;">
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*"
                       class="d-none @error('image') is-invalid @enderror"
                       onchange="previewImage(this)">
                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            {{-- Status --}}
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-toggles text-success me-2"></i>Pengaturan
                </h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" id="isActive" value="1"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="isActive">
                        Tampilkan di halaman publik
                    </label>
                </div>
                <p class="text-muted small mt-1 mb-0">
                    Jika dinonaktifkan, trip tidak akan muncul di halaman user.
                </p>
            </div>

            {{-- Tombol Submit --}}
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success rounded-3 py-3 fw-bold">
                    <i class="bi bi-check-lg me-2"></i>Simpan Data Gunung
                </button>
                <a href="{{ route('admin.mountains.index') }}" class="btn btn-outline-secondary rounded-3">
                    <i class="bi bi-arrow-left me-2"></i>Batal
                </a>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const wrapper = document.getElementById('previewWrapper');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                wrapper.classList.add('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush