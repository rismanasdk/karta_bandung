@extends('layouts.peserta')
@section('page-title', 'Pengumuman')

@section('content')
<div class="mb-4">
    <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Berita & Pengumuman</h4>
    <p class="text-muted small mb-0">Informasi resmi dari panitia KARTA.BDG Cup 2026</p>
</div>

<div class="row g-4">
    @forelse($news as $n)
    <div class="col-md-6">
        <div class="card border-0 card-karta h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    @php $catColors = ['Pengumuman'=>'warning','Berita'=>'info','Peraturan'=>'secondary']; @endphp
                    <span class="badge bg-{{ $catColors[$n->category] ?? 'secondary' }}" style="font-size:0.7rem;">{{ $n->category }}</span>
                    <span class="text-muted" style="font-size:0.72rem;">{{ $n->published_at?->translatedFormat('d M Y') }}</span>
                </div>
                <h6 class="fw-bold mb-2" style="color:#0a1628;">{{ $n->title }}</h6>
                <p class="text-muted small mb-3">{{ Str::limit($n->summary, 120) }}</p>
            </div>
            <div class="card-footer bg-white border-0 pt-0 pb-4 px-4">
                <a href="{{ route('berita.detail', $n->slug) }}" target="_blank" class="btn btn-outline-success btn-sm">
                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 card-karta">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-bullhorn fa-3x mb-3 d-block"></i>
                <h6 class="fw-bold">Belum ada pengumuman.</h6>
                <p class="small">Pengumuman resmi dari panitia akan muncul di sini.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@if($news->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $news->links('pagination::bootstrap-5') }}
</div>
@endif
@endsection
