@extends('layouts.peserta')
@section('page-title', 'Jadwal Pertandingan')

@section('content')
<div class="mb-4">
    <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Jadwal Pertandingan</h4>
    <p class="text-muted small mb-0">Jadwal lengkap pertandingan KARTA.BDG Men's Football Cup 2026</p>
</div>

@forelse($matches->groupBy(fn($m) => $m->match_date->format('Y-m-d')) as $date => $dayMatches)
<div class="mb-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="text-center px-3 py-2 rounded-3 fw-bold text-white" style="background:#0a1628;min-width:60px;">
            <div style="font-size:1.4rem;font-family:'Oswald',sans-serif;line-height:1;">{{ \Carbon\Carbon::parse($date)->format('d') }}</div>
            <div style="font-size:0.65rem;text-transform:uppercase;letter-spacing:0.1em;">{{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}</div>
        </div>
        <div>
            <div class="fw-bold" style="color:#0a1628;">{{ \Carbon\Carbon::parse($date)->translatedFormat('l') }}</div>
            <div class="text-muted small">{{ \Carbon\Carbon::parse($date)->format('Y') }}</div>
        </div>
        <div class="flex-grow-1" style="height:1px;background:#e9ecef;"></div>
    </div>

    <div class="row g-3">
        @foreach($dayMatches as $m)
        <div class="col-md-6">
            <div class="card border-0 card-karta p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-navy match-stage-badge">{{ $m->stage }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-clock text-success" style="font-size:0.8rem;"></i>
                        <span class="fw-bold small" style="color:#0a1628;">{{ $m->match_date->format('H:i') }} WIB</span>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                    <div class="text-center flex-grow-1">
                        <div class="fw-bold mb-1" style="color:#0a1628;">{{ $m->homeTeam->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">Tuan Rumah</div>
                    </div>
                    @if($m->status === 'Selesai')
                        <div class="match-score text-navy" style="background:#f1f5f9;">{{ $m->home_score }} – {{ $m->away_score }}</div>
                    @else
                        <div class="text-muted fw-bold px-3 py-2 rounded-2" style="font-family:'Oswald',sans-serif;font-size:1.1rem;background:#f1f5f9;">VS</div>
                    @endif
                    <div class="text-center flex-grow-1">
                        <div class="fw-bold mb-1" style="color:#0a1628;">{{ $m->awayTeam->name }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">Tim Tamu</div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                    <span class="text-muted" style="font-size:0.78rem;">
                        <i class="fas fa-map-marker-alt text-success me-1"></i>{{ $m->venue }}
                    </span>
                    @php $stc = ['Mendatang'=>'info','Berlangsung'=>'warning','Selesai'=>'success','Ditunda'=>'secondary']; @endphp
                    <span class="badge bg-{{ $stc[$m->status] ?? 'secondary' }}" style="font-size:0.68rem;">{{ $m->status }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="card border-0 card-karta">
    <div class="card-body text-center py-5 text-muted">
        <i class="fas fa-calendar fa-3x mb-3 d-block text-muted"></i>
        <h6 class="fw-bold">Jadwal Belum Tersedia</h6>
        <p class="small">Jadwal pertandingan akan segera diumumkan. Pantau terus halaman ini.</p>
    </div>
</div>
@endforelse
@endsection
