{{-- ══════════════════════════════════════════════════════════
     FILE: resources/views/admin/users/create.blade.php
══════════════════════════════════════════════════════════ --}}
@extends('layouts.admin')
@section('title','Tambah Pengguna')
@section('page-title','Tambah Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <h6 class="fw-bold mb-4 pb-2 border-bottom">
                <i class="bi bi-person-plus text-success me-2"></i>Form Tambah Pengguna
            </h6>
            <form action="{{ route('admin.users.store') }}" method="POST" data-loading>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control rounded-3 @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap"
                           value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control rounded-3 @error('email') is-invalid @enderror"
                           placeholder="email@contoh.com"
                           value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="user"  {{ old('role')=='user'  ? 'selected':'' }}>
                            👤 User (Pendaki)
                        </option>
                        <option value="admin" {{ old('role')=='admin' ? 'selected':'' }}>
                            🛡️ Admin (Pengelola)
                        </option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">
                        <strong>User</strong>: Bisa pesan trip & beri ulasan.
                        <strong>Admin</strong>: Akses penuh ke panel admin.
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                    <div class="position-relative">
                        <input type="password" name="password" id="passInput"
                               class="form-control rounded-3 @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter + angka"
                               style="padding-right:3rem;" required>
                        <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted"
                                onclick="this.previousElementSibling.type=this.previousElementSibling.type==='password'?'text':'password'; this.querySelector('i').className='bi bi-eye'+(this.previousElementSibling.type==='text'?'-slash':'');">
                            <i class="bi bi-eye fs-5"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation"
                           class="form-control rounded-3"
                           placeholder="Ulangi password" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success rounded-3 py-3 fw-bold">
                        <i class="bi bi-check-lg me-2"></i>Simpan Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="bi bi-arrow-left me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


{{-- ══════════════════════════════════════════════════════════
     FILE: resources/views/admin/users/edit.blade.php
══════════════════════════════════════════════════════════ --}}
{{-- CATATAN: Buat file terpisah edit.blade.php dengan isi di bawah --}}

{{-- @extends('layouts.admin')
@section('title','Edit Pengguna')
@section('page-title','Edit Pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
    <li class="breadcrumb-item active">Edit: {{ $user->name }}</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 rounded-4 shadow-sm p-4">
            <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                     style="width:46px; height:46px; font-size:1.1rem;
                            background:{{ $user->role==='admin' ? 'linear-gradient(135deg,#dc3545,#e07080)' : 'linear-gradient(135deg,#1a6b3a,#2d9a56)' }};">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Edit Pengguna</h6>
                    <span class="text-muted small">{{ $user->email }}</span>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" data-loading>
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nama Lengkap *</label>
                    <input type="text" name="name"
                           class="form-control rounded-3 @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email *</label>
                    <input type="email" name="email"
                           class="form-control rounded-3 @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Role *</label>
                    <select name="role" class="form-select rounded-3" required>
                        <option value="user"  {{ old('role',$user->role)==='user'  ? 'selected':'' }}>👤 User</option>
                        <option value="admin" {{ old('role',$user->role)==='admin' ? 'selected':'' }}>🛡️ Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                    <div class="form-text text-warning">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Mengubah role Anda sendiri akan mempengaruhi akses saat ini.
                    </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">
                        Password Baru <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password"
                           class="form-control rounded-3 @error('password') is-invalid @enderror"
                           placeholder="Min. 8 karakter + angka">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success rounded-3 py-3 fw-bold">
                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="bi bi-arrow-left me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection --}}