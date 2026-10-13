@extends('layouts.peserta')
@section('page-title', 'Profil Saya')

@section('content')
<div class="mb-4">
    <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Profil Saya</h4>
    <p class="text-muted small mb-0">Informasi akun Anda yang terdaftar</p>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 card-karta text-center p-4">
            <div class="mx-auto mb-3" style="width:80px;height:80px;border-radius:50%;background:#0a1628;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-0" style="color:#0a1628;">{{ auth()->user()->name }}</h5>
            <p class="text-muted small mb-2">{{ auth()->user()->email }}</p>
            @php $reg = auth()->user()->registration; @endphp
            @if($reg)
            <span class="badge badge-status status-{{ strtolower(str_replace(' ','',explode(' ',$reg->status)[0])) }}">{{ $reg->status }}</span>
            @else
            <span class="badge bg-secondary">Belum Mendaftar</span>
            @endif
            <div class="mt-3 pt-3 border-top text-muted small">
                Bergabung {{ auth()->user()->created_at?->translatedFormat('d F Y') ?? '-'}}
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 card-karta mb-4">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-user-edit text-success me-2"></i> Ubah Profil</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('peserta.profil.update') }}">
                    @csrf
                    @if(session('success'))
                    <div class="alert alert-success py-2 small mb-3"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Alamat Email</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                        <div class="form-text text-muted">Email tidak dapat diubah.</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <button type="submit" class="btn btn-green fw-bold"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-lock text-warning me-2"></i> Ubah Kata Sandi</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('peserta.pengaturan.password') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               minlength="8" placeholder="Minimal 8 karakter" required>
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
    </div>
</div>
@endsection
