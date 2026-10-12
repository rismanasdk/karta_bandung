@extends('layouts.public')
@section('title', 'Berita & Pengumuman – KARTA.BDG Cup 2026')

@section('content')
<div style="background:linear-gradient(135deg,#0a1628,#1a3356);padding:120px 0 60px;">
    <div class="container text-center text-white">
        <span class="section-overline text-success">Informasi Terkini</span>
        <h1 class="oswald fw-bold display-5 mt-1">Berita & Pengumuman</h1>
        <p class="text-white-50">KARTA.BDG Men's Football Cup 2026</p>
    </div>
</div>

<div class="container py-5">
    <!-- FILTER KATEGORI -->
    <div class="d-flex flex-wrap gap-2 mb-4 justify-content-center">
        <a href="{{ route('berita') }}" class="btn {{ !request('kategori') ? 'btn-navy' : 'btn-outline-secondary' }} btn-sm rounded-pill">Semua</a>
        @foreach(['Pengumuman','Berita','Peraturan'] as $k)
        <a href="{{ route('berita', ['kategori' => $k]) }}" class="btn {{ request('kategori') === $k ? 'btn-navy' : 'btn-outline-secondary' }} btn-sm rounded-pill">{{ $k }}</a>
        @endforeach
    </div>

    @if($news->count())
    <!-- FEATURED -->
    @php $featured = $news->first(); @endphp
    <div class="card border-0 card-karta mb-5 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5">
                <div style="height:100%;min-height:240px;background:linear-gradient(135deg,#0a1628,#1a9b52);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-newspaper" style="font-size:4rem;color:rgba(255,255,255,0.1);"></i>
                </div>
            </div>
            <div class="col-md-7 d-flex flex-column p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-success">{{ $featured->category }}</span>
                    <span class="text-muted small">{{ $featured->published_at?->translatedFormat('d F Y') }}</span>
                </div>
                <h3 class="oswald fw-bold mb-3" style="color:#0a1628;">{{ $featured->title }}</h3>
                <p class="text-muted flex-grow-1">{{ $featured->summary }}</p>
                <a href="{{ route('berita.detail', $featured->slug) }}" class="btn btn-green fw-bold align-self-start">
                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- GRID BERITA -->
    <div class="row g-4">
        @foreach($news->skip(1) as $n)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 card-karta h-100">
                <div style="height:160px;background:linear-gradient(135deg,#0a1628,#1a3356);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-newspaper" style="font-size:2.5rem;color:rgba(255,255,255,0.12);"></i>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-secondary-subtle text-secondary" style="font-size:0.7rem;">{{ $n->category }}</span>
                        <span class="text-muted" style="font-size:0.72rem;">{{ $n->published_at?->translatedFormat('d M Y') }}</span>
                    </div>
                    <h6 class="fw-bold mb-2" style="color:#0a1628;">{{ $n->title }}</h6>
                    <p class="text-muted small flex-grow-1">{{ Str::limit($n->summary, 100) }}</p>
                </div>
                <div class="card-footer bg-white border-0 pb-4 px-4 pt-0">
                    <a href="{{ route('berita.detail', $n->slug) }}" class="btn btn-outline-success btn-sm">
                        Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    @if($news->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $news->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
    @else
    <div class="text-center py-5 text-muted">
        <i class="fas fa-newspaper fa-3x mb-3 d-block"></i>
        <h5 class="fw-bold">Belum ada berita.</h5>
        <p>Berita dan pengumuman akan segera ditambahkan. Kunjungi kembali nanti!</p>
    </div>
    @endif
</div>
@endsection
