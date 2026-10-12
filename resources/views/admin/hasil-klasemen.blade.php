@extends('layouts.admin')
@section('page-title', 'Hasil & Klasemen')

@section('content')
<div class="row g-4">
    <!-- INPUT HASIL -->
    <div class="col-12">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h5 class="oswald fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-futbol text-success me-2"></i> Input Hasil Pertandingan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f1f5f9;">
                        <tr>
                            <th class="text-dark ps-4 fw-bold small">Pertandingan</th>
                            <th class="text-dark fw-bold small">Tanggal</th>
                            <th class="text-dark fw-bold small">Status</th>
                            <th class="text-dark fw-bold small">Skor</th>
                            <th class="text-dark text-center fw-bold small">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matches as $m)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold small" style="color:#0a1628;">
                                    {{ $m->homeTeam->name }} <span class="text-muted">vs</span> {{ $m->awayTeam->name }}
                                </div>
                                <span class="badge bg-navy" style="font-size:0.65rem;">{{ $m->stage }}</span>
                            </td>
                            <td class="small text-muted">{{ $m->match_date->format('d M Y, H:i') }}</td>
                            <td>
                                @php $sc = ['Mendatang'=>'info','Berlangsung'=>'warning','Selesai'=>'success','Ditunda'=>'secondary']; @endphp
                                <span class="badge bg-{{ $sc[$m->status] ?? 'secondary' }}">{{ $m->status }}</span>
                            </td>
                            <td>
                                @if($m->status === 'Selesai')
                                    <span class="fw-bold" style="color:#0a1628;font-family:'Oswald',sans-serif;font-size:1.1rem;">
                                        {{ $m->home_score }} – {{ $m->away_score }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($m->status !== 'Selesai')
                                <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalSkor{{ $m->id }}">
                                    <i class="fas fa-keyboard me-1"></i> Input Skor
                                </button>
                                <!-- Modal Skor -->
                                <div class="modal fade" id="modalSkor{{ $m->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content border-0 rounded-4">
                                            <div class="modal-header border-0" style="background:#0a1628;">
                                                <h6 class="modal-title text-white">Input Skor</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.hasil.input', $m->id) }}">
                                                @csrf
                                                <div class="modal-body p-4">
                                                    <p class="text-muted small text-center mb-3">{{ $m->homeTeam->name }} vs {{ $m->awayTeam->name }}</p>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="text-center flex-grow-1">
                                                            <label class="form-label fw-bold small">{{ Str::limit($m->homeTeam->name,12) }}</label>
                                                            <input type="number" name="home_score" class="form-control text-center fw-bold fs-4" min="0" value="0" required>
                                                        </div>
                                                        <div class="fw-bold text-muted">–</div>
                                                        <div class="text-center flex-grow-1">
                                                            <label class="form-label fw-bold small">{{ Str::limit($m->awayTeam->name,12) }}</label>
                                                            <input type="number" name="away_score" class="form-control text-center fw-bold fs-4" min="0" value="0" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="submit" class="btn btn-green w-100 fw-bold">
                                                        <i class="fas fa-save me-1"></i> Simpan & Perbarui Klasemen
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-success small"><i class="fas fa-check me-1"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Belum ada jadwal/data pertandingan yang perlu diinput
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KLASEMEN GRUP A -->
    <div class="col-lg-6">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-table text-success me-2"></i> Klasemen Grup A</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f1f5f9;">
                        <tr>
                            <th class="text-dark text-center ps-3 fw-bold small">Pos</th>
                            <th class="text-dark fw-bold small">Tim</th>
                            <th class="text-dark text-center fw-bold small">M</th>
                            <th class="text-dark text-center fw-bold small">W</th>
                            <th class="text-dark text-center fw-bold small">D</th>
                            <th class="text-dark text-center fw-bold small">L</th>
                            <th class="text-dark text-center fw-bold small">SG</th>
                            <th class="text-dark text-center fw-bold small">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupA as $i => $t)
                        <tr>
                            <td class="text-center ps-3 fw-bold @if($i==0) text-success @elseif($i==1) text-primary @elseif($i==2) text-warning @endif">{{ $i+1 }}</td>
                            <td class="fw-semibold small">{{ $t->name }}</td>
                            <td class="text-center small">{{ $t->played }}</td>
                            <td class="text-center small text-success fw-semibold">{{ $t->won }}</td>
                            <td class="text-center small">{{ $t->drawn }}</td>
                            <td class="text-center small text-danger">{{ $t->lost }}</td>
                            <td class="text-center small">{{ $t->goal_difference > 0 ? '+' : '' }}{{ $t->goal_difference }}</td>
                            <td class="text-center fw-bold" style="color:#0a1628;">{{ $t->points }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Belum ada data tim / klasemen untuk Grup A
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- KLASEMEN GRUP B -->
    <div class="col-lg-6">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-table text-primary me-2"></i> Klasemen Grup B</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f1f5f9;">
                        <tr>
                            <th class="text-dark text-center ps-3 fw-bold small">Pos</th>
                            <th class="text-dark fw-bold small">Tim</th>
                            <th class="text-dark text-center fw-bold small">M</th>
                            <th class="text-dark text-center fw-bold small">W</th>
                            <th class="text-dark text-center fw-bold small">D</th>
                            <th class="text-dark text-center fw-bold small">L</th>
                            <th class="text-dark text-center fw-bold small">SG</th>
                            <th class="text-dark text-center fw-bold small">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupB as $i => $t)
                        <tr>
                            <td class="text-center ps-3 fw-bold @if($i==0) text-success @elseif($i==1) text-primary @elseif($i==2) text-warning @endif">{{ $i+1 }}</td>
                            <td class="fw-semibold small">{{ $t->name }}</td>
                            <td class="text-center small">{{ $t->played }}</td>
                            <td class="text-center small text-success fw-semibold">{{ $t->won }}</td>
                            <td class="text-center small">{{ $t->drawn }}</td>
                            <td class="text-center small text-danger">{{ $t->lost }}</td>
                            <td class="text-center small">{{ $t->goal_difference > 0 ? '+' : '' }}{{ $t->goal_difference }}</td>
                            <td class="text-center fw-bold" style="color:#0a1628;">{{ $t->points }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted small">
                                <i class="fas fa-info-circle me-1"></i> Belum ada data tim / klasemen untuk Grup B
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
