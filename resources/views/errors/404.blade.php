@extends('layouts.app')
@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div style="min-height:85vh; display:flex; align-items:center; justify-content:center; padding-top:80px;">
    <div class="text-center" data-aos="zoom-in">
        <div style="font-size:7rem; line-height:1;">🏔️</div>
        <h1 class="display-4 fw-bold mt-3" style="color:#1a6b3a;">404</h1>
        <h4 class="fw-semibold text-muted mb-3">Halaman Tidak Ditemukan</h4>
        <p class="text-muted mb-4">
            Sepertinya Anda tersesat di jalur pendakian.<br>
            Halaman yang Anda cari tidak ada.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary-custom">
            <i class="bi bi-compass me-2"></i>Kembali ke Basecamp
        </a>
    </div>
</div>
@endsection