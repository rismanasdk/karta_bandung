@extends('layouts.peserta')
@section('page-title', 'Hasil & Klasemen')

@section('content')
<div class="mb-4">
    <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Hasil & Klasemen</h4>
    <p class="text-muted small mb-0">Pantau perkembangan turnamen secara real-time</p>
</div>

<ul class="nav nav-pills mb-4 gap-2">
    <li class="nav-item">
        <button class="nav-link active fw-semibold" data-bs-toggle="pill" data-bs-target="#klasemenTab">
            <i class="fas fa-table me-1"></i> Klasemen
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#hasilTab">
            <i class="fas fa-futbol me-1"></i> Hasil
        </button>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="klasemenTab">
        @foreach($standings as $groupName => $teams)
        <div class="card border-0 card-karta mb-4 overflow-hidden">
            <div class="card-header py-3" style="background:#0a1628;">
                <h6 class="oswald fw-bold mb-0 text-white"><i class="fas fa-layer-group text-success me-2"></i>{{ $groupName }}</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th class="ps-4 small text-muted border-0 fw-semibold">Pos</th>
                            <th class="small text-muted border-0 fw-semibold">Tim</th>
                            <th class="text-center small text-muted border-0 fw-semibold">M</th>
                            <th class="text-center small text-muted border-0 fw-semibold">W</th>
                            <th class="text-center small text-muted border-0 fw-semibold">D</th>
                            <th class="text-center small text-muted border-0 fw-semibold">L</th>
                            <th class="text-center small text-muted border-0 fw-semibold">SG</th>
                            <th class="text-center small text-muted border-0 fw-semibold">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $i => $t)
                        <tr>
                            <td class="ps-4 fw-bold @if($i==0) text-success @elseif($i==1) text-primary @elseif($i==2) text-warning @endif">{{ $i+1 }}</td>
                            <td class="fw-semibold small" style="color:#0a1628;">{{ $t->name }}</td>
                            <td class="text-center small">{{ $t->played }}</td>
                            <td class="text-center small text-success fw-semibold">{{ $t->won }}</td>
                            <td class="text-center small">{{ $t->drawn }}</td>
                            <td class="text-center small text-danger">{{ $t->lost }}</td>
                            <td class="text-center small">{{ $t->goal_difference > 0 ? '+' : '' }}{{ $t->goal_difference }}</td>
                            <td class="text-center fw-bold" style="color:#0a1628;">{{ $t->points }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>

    <div class="tab-pane fade" id="hasilTab">
        <div class="row g-3">
            @forelse($finishedMatches as $m)
            <div class="col-md-6">
                <div class="card border-0 card-karta p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-navy match-stage-badge">{{ $m->stage }}</span>
                        <span class="text-muted" style="font-size:0.72rem;">{{ $m->match_date->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <span class="fw-semibold small flex-grow-1 text-truncate" style="color:#0a1628;">{{ $m->homeTeam->name }}</span>
                        <span class="match-score text-navy" style="font-size:1.3rem;padding:6px 12px;">{{ $m->home_score }} – {{ $m->away_score }}</span>
                        <span class="fw-semibold small flex-grow-1 text-end text-truncate" style="color:#0a1628;">{{ $m->awayTeam->name }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-futbol fa-2x mb-2 d-block"></i>
                Belum ada hasil pertandingan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
