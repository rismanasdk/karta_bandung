@extends('layouts.public')
@section('title', 'Buat Akun – KARTA.BDG Cup 2026')

@section('content')
<div style="background:linear-gradient(135deg,#0a1628 0%,#1a3356 100%);min-height:100vh;display:flex;align-items:center;padding:100px 0 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="row g-0 rounded-4 overflow-hidden shadow-lg">

                    <!-- LEFT -->
                    <div class="col-md-5 d-none d-md-flex flex-column justify-content-between p-5"
                         style="background:linear-gradient(160deg,#0a1628,#1a9b52);">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo KARTA.BDG" style="height: 48px; width: auto;">
                                <span class="oswald fs-3 fw-bold text-white">KARTA.BDG</span>
                            </div>
                            <p class="text-white-50 small">Men's Football Cup 2026</p>
                        </div>
                        <div>
                            <h3 class="oswald text-white fw-bold mb-3">Bergabung Sekarang!</h3>
                            <p class="text-white-50 small mb-4">Daftarkan akun Anda untuk berpartisipasi dalam turnamen sepak bola paling bergengsi se-Kota Bandung.</p>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex gap-2 align-items-center text-white-50 small"><i class="fas fa-check-circle text-success"></i> Pendaftaran 100% gratis</div>
                                <div class="d-flex gap-2 align-items-center text-white-50 small"><i class="fas fa-check-circle text-success"></i> Hanya perlu email & kata sandi</div>
                                <div class="d-flex gap-2 align-items-center text-white-50 small"><i class="fas fa-check-circle text-success"></i> Upload dokumen setelah akun dibuat</div>
                            </div>
                        </div>
                        <div>
                            <p class="text-white-50 small mb-0">Sudah punya akun?</p>
                            <a href="{{ route('login') }}" class="text-success fw-semibold small">Masuk di sini →</a>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-7 bg-white p-5">
                        <h4 class="oswald fw-bold mb-1" style="color:#0a1628;">Buat Akun Baru</h4>
                        <p class="text-muted small mb-4">Isi data berikut untuk membuat akun peserta. Dokumen KTP akan diminta setelah akun dibuat.</p>

                        @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Nama sesuai KTP" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Alamat Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           placeholder="contoh@email.com" value="{{ old('email') }}" required>
                                </div>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="text" name="phone" class="form-control"
                                           placeholder="08xx-xxxx-xxxx" value="{{ old('phone') }}">
                                </div>
                                <div class="form-text text-muted">Opsional – untuk keperluan komunikasi panitia</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small">Kata Sandi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small">Konfirmasi Kata Sandi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-green w-100 fw-bold py-2">
                                <i class="fas fa-user-plus me-2"></i> Buat Akun Sekarang
                            </button>
                        </form>

                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted small mb-0">Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-success fw-semibold">Masuk di sini</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
