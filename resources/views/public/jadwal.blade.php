@extends('layouts.public')
@section('title', 'Jadwal Pertandingan – KARTA.BDG Cup 2026')

@section('content')
<div style="background:linear-gradient(135deg,#0a1628,#1a3356);padding:120px 0 60px;">
    <div class="container text-center text-white">
        <span class="section-overline text-success">Turnamen</span>
        <h1 class="oswald fw-bold display-5 mt-1">Jadwal Pertandingan</h1>
        <p class="text-white-50">KARTA.BDG Men's Football Cup 2026</p>
    </div>
</div>

<div class="container py-5">
    @forelse($matches->groupBy(fn($m) => $m->match_date->format('Y-m-d')) as $date => $dayMatches)
    <div class="mb-5">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="rounded-3 text-center text-white fw-bold px-3 py-2" style="background:#0a1628;min-width:64px;">
                <div style="font-family:'Oswald',sans-serif;font-size:1.8rem;line-height:1;">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
                <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;">{{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}</div>
            </div>
            <div>
                <h5 class="oswald fw-bold mb-0" style="color:#0a1628;">{{ \Carbon\Carbon::parse($date)->translatedFormat('l') }}</h5>
                <span class="text-muted small">{{ \Carbon\Carbon::parse($date)->format('Y') }}</span>
            </div>
            <div class="flex-grow-1" style="height:2px;background:#e9ecef;"></div>
            <span class="badge" style="background:#f1f5f9;color:#64748b;">{{ $dayMatches->count() }} Pertandingan</span>
        </div>

        <div class="row g-3">
            @foreach($dayMatches as $m)
            <div class="col-md-6 col-lg-4">
                <div class="match-card bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-navy match-stage-badge">{{ $m->stage }}</span>
                        @php $sc = ['Mendatang'=>'info','Berlangsung'=>'warning','Selesai'=>'success','Ditunda'=>'secondary']; @endphp
                        <span class="badge bg-{{ $sc[$m->status] ?? 'secondary' }}">{{ $m->status }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
                        <div class="text-center flex-grow-1">
                            <div class="fw-bold" style="color:#0a1628;font-size:0.88rem;">{{ $m->homeTeam->name }}</div>
                            <div class="text-muted" style="font-size:0.68rem;">Tuan Rumah</div>
                        </div>
                        @if($m->status === 'Selesai')
                            <div class="match-score text-navy">{{ $m->home_score }} – {{ $m->away_score }}</div>
                        @else
                            <div class="text-muted fw-bold rounded-2" style="font-family:'Oswald',sans-serif;font-size:1.2rem;background:#f1f5f9;padding:8px 16px;">VS</div>
                        @endif
                        <div class="text-center flex-grow-1">
                            <div class="fw-bold" style="color:#0a1628;font-size:0.88rem;">{{ $m->awayTeam->name }}</div>
                            <div class="text-muted" style="font-size:0.68rem;">Tim Tamu</div>
                        </div>
                    </div>
                    <div class="pt-3 border-top d-flex flex-column gap-1">
                        <div class="text-muted" style="font-size:0.78rem;"><i class="fas fa-clock text-success me-1"></i>{{ $m->match_date->format('H:i') }} WIB</div>
                        <div class="text-muted" style="font-size:0.78rem;"><i class="fas fa-map-marker-alt text-success me-1"></i>{{ $m->venue }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
        <i class="fas fa-calendar-times fa-3x mb-3 d-block"></i>
        <h5 class="fw-bold">Jadwal Belum Tersedia</h5>
        <p>Jadwal pertandingan akan segera diumumkan. Pantau terus halaman ini!</p>
    </div>
    @endforelse
</div>
@endsection
