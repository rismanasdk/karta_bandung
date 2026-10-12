@extends('layouts.public')
@section('title', 'Hasil & Klasemen – KARTA.BDG Cup 2026')

@section('content')
<div style="background:linear-gradient(135deg,#0a1628,#1a3356);padding:120px 0 60px;">
    <div class="container text-center text-white">
        <span class="section-overline text-success">Kompetisi</span>
        <h1 class="oswald fw-bold display-5 mt-1">Hasil & Klasemen</h1>
        <p class="text-white-50">KARTA.BDG Men's Football Cup 2026</p>
    </div>
</div>

<div class="container py-5">
    <!-- NAV TABS -->
    <ul class="nav nav-pills mb-4 justify-content-center gap-2" id="tabs">
        <li class="nav-item">
            <button class="nav-link active fw-semibold" data-bs-toggle="pill" data-bs-target="#klasemen">
                <i class="fas fa-table me-2"></i> Klasemen
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#hasil">
                <i class="fas fa-futbol me-2"></i> Hasil Pertandingan
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- KLASEMEN -->
        <div class="tab-pane fade show active" id="klasemen">
            <div class="row g-4">
                @foreach($standings as $groupName => $teams)
                <div class="col-12">
                    <div class="card border-0 card-karta overflow-hidden">
                        <div class="card-header py-3 d-flex align-items-center gap-2" style="background:#0a1628;">
                            <i class="fas fa-layer-group text-success"></i>
                            <h5 class="oswald fw-bold mb-0 text-white">{{ $groupName }}</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr style="background:#f8fafc;">
                                        <th class="ps-4 text-muted small fw-semibold border-0" style="width:50px;">Pos</th>
                                        <th class="text-muted small fw-semibold border-0">Tim</th>
                                        <th class="text-center text-muted small fw-semibold border-0">Main</th>
                                        <th class="text-center text-muted small fw-semibold border-0">Menang</th>
                                        <th class="text-center text-muted small fw-semibold border-0">Seri</th>
                                        <th class="text-center text-muted small fw-semibold border-0">Kalah</th>
                                        <th class="text-center text-muted small fw-semibold border-0">GM</th>
                                        <th class="text-center text-muted small fw-semibold border-0">GK</th>
                                        <th class="text-center text-muted small fw-semibold border-0">SG</th>
                                        <th class="text-center text-muted small fw-semibold border-0 pe-4">Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $i => $team)
                                    <tr class="{{ $i < 2 ? 'table-success' : '' }}" style="{{ $i < 2 ? 'background:rgba(34,197,94,0.05)!important;' : '' }}">
                                        <td class="ps-4 fw-bold
                                            @if($i==0) text-success
                                            @elseif($i==1) text-primary
                                            @elseif($i==2) text-warning
                                            @endif">{{ $i+1 }}</td>
                                        <td>
                                            <span class="fw-bold" style="color:#0a1628;">{{ $team->name }}</span>
                                            @if($i < 2)
                                            <span class="badge bg-success ms-1" style="font-size:0.6rem;">Lolos</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $team->played }}</td>
                                        <td class="text-center fw-semibold text-success">{{ $team->won }}</td>
                                        <td class="text-center">{{ $team->drawn }}</td>
                                        <td class="text-center text-danger">{{ $team->lost }}</td>
                                        <td class="text-center">{{ $team->goals_for }}</td>
                                        <td class="text-center">{{ $team->goals_against }}</td>
                                        <td class="text-center fw-semibold {{ $team->goal_difference >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $team->goal_difference > 0 ? '+' : '' }}{{ $team->goal_difference }}
                                        </td>
                                        <td class="text-center pe-4 fw-bold fs-5" style="color:#0a1628;">{{ $team->points }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white border-top py-2 px-4">
                            <div class="d-flex gap-3 flex-wrap" style="font-size:0.72rem;color:#94a3b8;">
                                <span><span class="badge bg-success me-1" style="font-size:0.6rem;">●</span> Lolos ke babak selanjutnya</span>
                                <span>Main = Jumlah pertandingan dimainkan</span>
                                <span>SG = Selisih Gol</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- HASIL -->
        <div class="tab-pane fade" id="hasil">
            <div class="row g-3">
                @forelse($finishedMatches as $m)
                <div class="col-md-6 col-lg-4">
                    <div class="match-card bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-navy match-stage-badge">{{ $m->stage }}</span>
                            <span class="text-muted" style="font-size:0.75rem;">{{ $m->match_date->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                            <div class="text-center flex-grow-1">
                                <div class="fw-bold" style="color:#0a1628;font-size:0.88rem;">{{ $m->homeTeam->name }}</div>
                            </div>
                            <div class="match-score text-navy">{{ $m->home_score }} – {{ $m->away_score }}</div>
                            <div class="text-center flex-grow-1">
                                <div class="fw-bold" style="color:#0a1628;font-size:0.88rem;">{{ $m->awayTeam->name }}</div>
                            </div>
                        </div>
                        @php
                            $homeWin = $m->home_score > $m->away_score;
                            $awayWin = $m->away_score > $m->home_score;
                            $draw = $m->home_score == $m->away_score;
                        @endphp
                        <div class="text-center">
                            @if($draw)
                            <span class="badge bg-secondary">Seri</span>
                            @elseif($homeWin)
                            <span class="badge bg-success">{{ $m->homeTeam->name }} Menang</span>
                            @else
                            <span class="badge bg-success">{{ $m->awayTeam->name }} Menang</span>
                            @endif
                        </div>
                        <div class="mt-2 text-muted text-center" style="font-size:0.75rem;">
                            <i class="fas fa-map-marker-alt text-success me-1"></i>{{ $m->venue }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-futbol fa-3x mb-3 d-block"></i>
                    <h6 class="fw-bold">Belum Ada Hasil Pertandingan</h6>
                    <p class="small">Hasil pertandingan akan muncul di sini setelah pertandingan selesai.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
