@extends('layouts.app')
@section('title', '403 - Akses Ditolak')

@section('content')
<div style="min-height:85vh; display:flex; align-items:center; justify-content:center; padding-top:80px;">
    <div class="text-center" data-aos="zoom-in">
        <div style="font-size:7rem; line-height:1; color:#dee2e6;">🔒</div>
        <h1 class="display-4 fw-bold mt-3" style="color:#1a6b3a;">403</h1>
        <h4 class="fw-semibold text-muted mb-3">Akses Ditolak</h4>
        <p class="text-muted mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary-custom me-2">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-house me-2"></i>Ke Beranda
        </a>
    </div>
</div>
@endsection