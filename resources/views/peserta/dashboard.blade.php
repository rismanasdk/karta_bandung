@extends('layouts.peserta')
@section('page-title', 'Dashboard Peserta')

@section('content')
{{-- HEADER SAPAAN --}}
<div class="rounded-4 p-4 mb-4 text-white" style="background:linear-gradient(135deg,#0a1628,#1a3356);">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <p class="mb-1 text-white-50 small">Selamat datang kembali,</p>
            <h4 class="oswald fw-bold mb-1">{{ $user->name }} 👋</h4>
            <p class="mb-0 text-white-50 small">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="text-end">
            @if(!$registration)
                <span class="badge bg-secondary fs-6 px-3 py-2">Belum Mendaftar</span>
                <p class="text-white-50 small mb-0 mt-1">Segera lengkapi pendaftaran Anda</p>
            @elseif($registration->status === 'Menunggu Verifikasi')
                <span class="badge bg-warning text-dark fs-6 px-3 py-2">Menunggu Verifikasi</span>
                <p class="text-white-50 small mb-0 mt-1">Verifikasi pemain tgl 2 Nov s/d 10 Nov 2026</p>
            @elseif($registration->status === 'Terverifikasi')
                <span class="badge bg-success fs-6 px-3 py-2">✓ Terverifikasi</span>
                <p class="text-white-50 small mb-0 mt-1">Pendaftaran Anda telah diterima!</p>
            @elseif($registration->status === 'Ditolak')
                <span class="badge bg-danger fs-6 px-3 py-2">✗ Ditolak</span>
                <p class="text-white-50 small mb-0 mt-1">Lihat alasan dan perbaiki pendaftaran</p>
            @endif
        </div>
    </div>
</div>

{{-- ALERT DITOLAK --}}
@if($registration && $registration->status === 'Ditolak')
<div class="alert alert-danger d-flex align-items-start gap-3 mb-4">
    <i class="fas fa-times-circle fa-lg mt-1"></i>
    <div>
        <strong>Pendaftaran Ditolak</strong>
        <p class="mb-2 small">Alasan: {{ $registration->rejection_reason }}</p>
        <a href="{{ route('peserta.pendaftaran') }}" class="btn btn-sm btn-danger fw-bold">
            <i class="fas fa-redo me-1"></i> Perbaiki Pendaftaran
        </a>
    </div>
</div>
@endif

{{-- INFO KELENGKAPAN --}}
@if($registration)
<div class="card border-0 card-karta mb-4">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3" style="color:#0a1628;"><i class="fas fa-clipboard-check text-success me-2"></i> Kelengkapan Dokumen</h6>
        <div class="row g-3">
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background:#f8fafc;">
                    <i class="fas fa-shield-alt {{ $registration->nama_tim ? 'text-success' : 'text-muted' }} fa-lg"></i>
                    <div>
                        <div class="fw-semibold small">Data Tim</div>
                        <div style="font-size:0.72rem;" class="{{ $registration->nama_tim ? 'text-success' : 'text-muted' }}">
                            {{ $registration->nama_tim ? 'Lengkap' : 'Belum diisi' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background:#f8fafc;">
                    <i class="fas fa-users {{ $registration->members()->where('tipe', 'pemain')->count() > 0 ? 'text-success' : 'text-warning' }} fa-lg"></i>
                    <div>
                        <div class="fw-semibold small">Data Pemain</div>
                        <div style="font-size:0.72rem;" class="{{ $registration->members()->where('tipe', 'pemain')->count() > 0 ? 'text-success' : 'text-warning' }}">
                            {{ $registration->members()->where('tipe', 'pemain')->count() }} Terdaftar
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background:#f8fafc;">
                    <i class="fas fa-user-tie {{ $registration->members()->where('tipe', 'official')->count() > 0 ? 'text-success' : 'text-muted' }} fa-lg"></i>
                    <div>
                        <div class="fw-semibold small">Data Official</div>
                        <div style="font-size:0.72rem;" class="{{ $registration->members()->where('tipe', 'official')->count() > 0 ? 'text-success' : 'text-muted' }}">
                            {{ $registration->members()->where('tipe', 'official')->count() }} Terdaftar
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row g-4">
    {{-- AKSES CEPAT --}}
    <div class="col-md-4">
        <div class="card border-0 card-karta h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color:#0a1628;"><i class="fas fa-bolt text-warning me-2"></i> Akses Cepat</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('peserta.pendaftaran') }}" class="btn btn-green fw-semibold">
                        <i class="fas fa-file-alt me-2"></i> {{ $registration ? 'Lihat Pendaftaran' : 'Mulai Pendaftaran' }}
                    </a>
                    <a href="{{ route('peserta.jadwal') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-calendar me-2"></i> Jadwal Pertandingan
                    </a>
                    <a href="{{ route('peserta.hasil-klasemen') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-trophy me-2"></i> Hasil & Klasemen
                    </a>
                    <a href="{{ route('peserta.notifikasi') }}" class="btn btn-outline-secondary position-relative">
                        <i class="fas fa-bell me-2"></i> Notifikasi
                        @if($unreadNotifications > 0)
                        <span class="badge bg-danger position-absolute top-0 end-0 translate-middle rounded-pill" style="font-size:0.65rem;">{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- JADWAL MENDATANG --}}
    <div class="col-md-8">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-calendar-alt text-success me-2"></i> Pertandingan Mendatang</h6>
                <a href="{{ route('peserta.jadwal') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($upcomingMatches as $m)
                <div class="px-4 py-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="badge bg-navy match-stage-badge">{{ $m->stage }}</span>
                        <span class="text-muted" style="font-size:0.72rem;">{{ $m->match_date->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-3 py-2">
                        <span class="fw-bold" style="color:#0a1628;font-size:0.9rem;">{{ $m->homeTeam->name }}</span>
                        <span class="badge bg-light text-dark border fw-bold">VS</span>
                        <span class="fw-bold" style="color:#0a1628;font-size:0.9rem;">{{ $m->awayTeam->name }}</span>
                    </div>
                    <div class="text-muted text-center" style="font-size:0.75rem;">
                        <i class="fas fa-map-marker-alt text-success me-1"></i>{{ $m->venue }}
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar fa-2x mb-2 d-block text-muted"></i>
                    Belum ada jadwal pertandingan mendatang.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PENGUMUMAN TERBARU --}}
    <div class="col-12">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-bullhorn text-warning me-2"></i> Pengumuman Terbaru</h6>
                <a href="{{ route('peserta.pengumuman') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($latestNews as $n)
                <div class="d-flex gap-3 px-4 py-3 border-bottom align-items-start">
                    <div class="flex-shrink-0 mt-1">
                        @php $catIcons = ['Pengumuman'=>'fa-bullhorn text-warning','Berita'=>'fa-newspaper text-info','Peraturan'=>'fa-gavel text-secondary']; @endphp
                        <i class="fas {{ $catIcons[$n->category] ?? 'fa-info-circle text-muted' }}"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold small" style="color:#0a1628;">{{ $n->title }}</span>
                            <span class="badge bg-light text-muted border" style="font-size:0.65rem;">{{ $n->category }}</span>
                        </div>
                        <div class="text-muted" style="font-size:0.78rem;">{{ Str::limit($n->summary, 100) }}</div>
                    </div>
                    <div class="text-muted flex-shrink-0" style="font-size:0.72rem;">{{ $n->published_at?->diffForHumans() }}</div>
                </div>
                @empty
                <div class="text-center text-muted py-4">Belum ada pengumuman terbaru.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
