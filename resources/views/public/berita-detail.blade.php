@extends('layouts.public')
@section('title', $article->title . ' – KARTA.BDG Cup 2026')
@section('description', $article->summary)

@section('content')
<div style="background:linear-gradient(135deg,#0a1628,#1a3356);padding:120px 0 60px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center text-white">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                    <span class="badge bg-success">{{ $article->category }}</span>
                    <span class="text-white-50 small">{{ $article->published_at?->translatedFormat('d F Y') }}</span>
                </div>
                <h1 class="oswald fw-bold display-6 mb-3">{{ $article->title }}</h1>
                <p class="text-white-50">{{ $article->summary }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="{{ route('berita') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Berita
                </a>
            </div>
            <div class="card border-0 card-karta p-4 p-md-5">
                <div class="prose" style="line-height:1.85;color:#374151;">
                    {!! nl2br(e($article->content)) !!}
                </div>
                <hr class="my-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="fas fa-user-circle text-success"></i>
                        Ditulis oleh {{ $article->author->name ?? 'Panitia KARTA.BDG' }}
                    </div>
                    <div class="d-flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="fab fa-whatsapp me-1"></i> Bagikan
                        </a>
                    </div>
                </div>
            </div>

            @if($relatedNews->count())
            <div class="mt-5">
                <h5 class="oswald fw-bold mb-4" style="color:#0a1628;">Artikel Terkait</h5>
                <div class="row g-3">
                    @foreach($relatedNews as $r)
                    <div class="col-md-6">
                        <a href="{{ route('berita.detail', $r->slug) }}" class="card border-0 card-karta p-3 text-decoration-none hover:shadow-md">
                            <div class="d-flex gap-2 align-items-center mb-1">
                                <span class="badge bg-light text-muted border" style="font-size:0.65rem;">{{ $r->category }}</span>
                                <span class="text-muted" style="font-size:0.72rem;">{{ $r->published_at?->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="fw-semibold small" style="color:#0a1628;">{{ Str::limit($r->title, 70) }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
