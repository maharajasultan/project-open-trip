@extends('layouts.admin')
@section('title', 'Edit Gunung')
@section('page-title', 'Edit Data Gunung')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mountains.index') }}">Gunung</a></li>
    <li class="breadcrumb-item active">Edit: {{ $mountain->name }}</li>
@endsection

@section('content')

<form action="{{ route('admin.mountains.update', $mountain) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-4">

        {{-- KOLOM KIRI --}}
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-4 pb-2 border-bottom">
                    <i class="bi bi-mountain text-success me-2"></i>Informasi Dasar
                </h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small">Nama Gunung <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control rounded-3 @error('name') is-invalid @enderror"
                               value="{{ old('name', $mountain->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Tingkat Kesulitan</label>
                        <select name="difficulty" class="form-select rounded-3">
                            <option value="">-- Pilih --</option>
                            @foreach(['Easy','Medium','Hard'] as $d)
                            <option value="{{ $d }}"
                                {{ old('difficulty', $mountain->difficulty) == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Lokasi</label>
                        <input type="text" name="location" class="form-control rounded-3"
                               value="{{ old('location', $mountain->location) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Ketinggian (mdpl)</label>
                        <input type="number" name="altitude" class="form-control rounded-3"
                               value="{{ old('altitude', $mountain->altitude) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Harga Per Orang (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-3 bg-light small text-muted fw-semibold">Rp</span>
                            <input type="number" name="price" min="0" step="1000"
                                   class="form-control rounded-end-3 @error('price') is-invalid @enderror"
                                   value="{{ old('price', $mountain->price) }}" required>
                        </div>
                        @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Kuota <span class="text-danger">*</span></label>
                        <input type="number" name="quota" min="1"
                               class="form-control rounded-3 @error('quota') is-invalid @enderror"
                               value="{{ old('quota', $mountain->quota) }}" required>
                        <div class="form-text">Sudah daftar: <strong>{{ $mountain->registered_count }}</strong> orang</div>
                        @error('quota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small">Tanggal & Waktu Keberangkatan <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="departure_date"
                               class="form-control rounded-3 @error('departure_date') is-invalid @enderror"
                               value="{{ old('departure_date', $mountain->departure_date->format('Y-m-d\TH:i')) }}" required>
                        @error('departure_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-file-text text-success me-2"></i>Deskripsi Trip
                </h6>
                <textarea name="description" rows="4"
                          class="form-control rounded-3 @error('description') is-invalid @enderror">{{ old('description', $mountain->description) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="card border-0 rounded-4 shadow-sm p-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-map text-success me-2"></i>Itinerary Perjalanan
                </h6>
                <textarea name="itinerary" rows="10"
                          class="form-control rounded-3 font-monospace @error('itinerary') is-invalid @enderror"
                          style="font-size:.85rem; line-height:1.7;">{{ old('itinerary', $mountain->itinerary) }}</textarea>
                @error('itinerary') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-image text-success me-2"></i>Foto Gunung
                </h6>
                {{-- Gambar saat ini --}}
                @if($mountain->image)
                <div class="mb-3">
                    <p class="text-muted small mb-2">Gambar saat ini:</p>
                    <img src="{{ $mountain->image_url }}" alt="{{ $mountain->name }}"
                         class="img-fluid rounded-3" style="max-height:180px; width:100%; object-fit:cover;">
                </div>
                @endif
                <label class="form-label fw-semibold small">Ganti Gambar (opsional)</label>
                <input type="file" name="image" class="form-control rounded-3 @error('image') is-invalid @enderror"
                       accept="image/*" onchange="previewNewImage(this)">
                <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                <img id="newImagePreview" src="" alt="Preview" class="img-fluid rounded-3 mt-2 d-none">
                @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3 pb-2 border-bottom">
                    <i class="bi bi-toggles text-success me-2"></i>Pengaturan
                </h6>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox"
                           name="is_active" id="isActive" value="1"
                           {{ old('is_active', $mountain->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="isActive">
                        Tampilkan di halaman publik
                    </label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success rounded-3 py-3 fw-bold">
                    <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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
    function previewNewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('newImagePreview');
                img.src = e.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush