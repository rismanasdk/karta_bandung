@extends('layouts.app')
@section('layout')
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-karta" id="navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo KARTA.BDG" style="height: 45px; width: auto;">
            <div class="d-flex flex-column lh-1">
                <span class="fw-bold">KARTA.BDG</span>
                <small style="font-family:'Inter',sans-serif;font-size:0.6rem;font-weight:400;color:rgba(255,255,255,0.5);letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">Men's Football Cup 2026</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('jadwal') ? 'active' : '' }}" href="{{ route('jadwal') }}">Jadwal</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('hasil-klasemen') ? 'active' : '' }}" href="{{ route('hasil-klasemen') }}">Klasemen</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('berita*') ? 'active' : '' }}" href="{{ route('berita') }}">Pengumuman</a></li>
            </ul>
            @auth
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-green btn-sm"><i class="fas fa-cog me-1"></i> Panel Admin</a>
                @else
                    <a href="{{ route('peserta.dashboard') }}" class="btn btn-green btn-sm"><i class="fas fa-user me-1"></i> Dashboard Saya</a>
                @endif
            </div>
            @endauth
        </div>
    </div>
</nav>

@yield('content')

<!-- FOOTER -->
<footer class="footer-karta py-5 mt-5">
    <div class="container">
        <div class="row g-4 pb-4 border-bottom border-secondary">
            <div class="col-lg-4">
                <div class="oswald fs-4 fw-bold text-white mb-2">⚽ KARTA.BDG</div>
                <p class="small mb-3">Turnamen sepak bola bergengsi antar kecamatan se-Kota Bandung. Mempererat persaudaraan dan mengangkat bakat lokal.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="mb-3">Navigasi</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('beranda') }}">Beranda</a>
                    <a href="{{ route('tentang') }}">Tentang Turnamen</a>
                    <a href="{{ route('jadwal') }}">Jadwal</a>
                    <a href="{{ route('hasil-klasemen') }}">Hasil & Klasemen</a>
                    <a href="{{ route('berita') }}">Pengumuman</a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="mb-3">Peserta</h6>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('register') }}">Buat Akun</a>
                    <a href="{{ route('login') }}">Masuk</a>
                    @auth
                    <a href="{{ route('peserta.pendaftaran') }}">Pendaftaran</a>
                    <a href="{{ route('peserta.jadwal') }}">Jadwal Tim</a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-4">
                <h6 class="mb-3">Informasi Kontak</h6>
                <div class="d-flex flex-column gap-2 small">
                    <span><i class="fas fa-map-marker-alt text-green me-2"></i> Kota Bandung, Jawa Barat</span>
                    <span><i class="fas fa-calendar text-green me-2"></i> November – Desember 2026</span>
                    <span><i class="fas fa-envelope text-green me-2"></i> info@karta-bdg.id</span>
                    <span><i class="fas fa-phone text-green me-2"></i> +62 812-XXXX-XXXX</span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 small">
            <span>&copy; 2026 KARTA.BDG Men's Football Cup. Seluruh hak dilindungi.</span>
            <span>Dibuat dengan ❤️ untuk sepak bola Bandung</span>
        </div>
    </div>
</footer>

@push('scripts')
<script>
// Navbar scroll
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 60);
});
</script>
@endpush
@endsection
