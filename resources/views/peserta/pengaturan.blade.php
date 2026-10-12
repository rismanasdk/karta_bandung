@extends('layouts.peserta')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="mb-4">
    <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Pengaturan Akun</h4>
    <p class="text-muted small mb-0">Kelola keamanan dan preferensi akun Anda</p>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 card-karta mb-4">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-lock text-warning me-2"></i> Ubah Kata Sandi</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('peserta.pengaturan.password') }}">
                    @csrf
                    @if(session('password_success'))
                    <div class="alert alert-success py-2 small"><i class="fas fa-check-circle me-1"></i>{{ session('password_success') }}</div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning fw-bold"><i class="fas fa-key me-2"></i> Perbarui Kata Sandi</button>
                </form>
            </div>
        </div>

        <div class="card border-0 card-karta" style="border-left:4px solid #ef4444!important;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-1 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Zona Berbahaya</h6>
                <p class="text-muted small mb-3">Tindakan berikut bersifat permanen dan tidak dapat dibatalkan.</p>
                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar dari semua perangkat?')">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Keluar dari Semua Perangkat
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
