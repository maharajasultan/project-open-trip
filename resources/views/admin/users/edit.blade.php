@extends('layouts.admin')
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
                    <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name"
                           class="form-control rounded-3 @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control rounded-3 @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select rounded-3 @error('role') is-invalid @enderror" required>
                        <option value="user"  {{ old('role',$user->role)==='user'  ? 'selected':'' }}>👤 User (Pendaki)</option>
                        <option value="admin" {{ old('role',$user->role)==='admin' ? 'selected':'' }}>🛡️ Admin (Pengelola)</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if($user->id === auth()->id())
                    <div class="form-text text-warning">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Mengubah role Anda sendiri akan mempengaruhi akses saat ini.
                    </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">
                        Password Baru
                        <span class="text-muted fw-normal">(kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="position-relative">
                        <input type="password" name="password" id="editPass"
                               class="form-control rounded-3 @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter + angka"
                               style="padding-right:3rem;">
                        <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted"
                                onclick="const i=document.getElementById('editPass');i.type=i.type==='password'?'text':'password';this.querySelector('i').className='bi bi-eye'+(i.type==='text'?'-slash':'');">
                            <i class="bi bi-eye fs-5"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- Info akun --}}
                <div class="p-3 bg-light rounded-3 mb-4 small text-muted">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Transaksi</span>
                        <strong class="text-dark">{{ $user->transactions_count ?? $user->transactions()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Ulasan</span>
                        <strong class="text-dark">{{ $user->reviews_count ?? $user->reviews()->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Bergabung</span>
                        <strong class="text-dark">{{ $user->created_at->format('d M Y') }}</strong>
                    </div>
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
@endsection