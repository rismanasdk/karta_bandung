@extends('layouts.admin')
@section('page-title', 'Kelola Pertandingan')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Pertandingan</h4>
        <p class="text-muted small mb-0">Atur jadwal dan data pertandingan turnamen</p>
    </div>
    <button class="btn btn-green fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus me-2"></i> Tambah Pertandingan
    </button>
</div>

<!-- TABLE -->
<div class="card border-0 card-karta">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="standings-table">
                    <th class="text-white ps-4">#</th>
                    <th class="text-white">Tim Tuan Rumah</th>
                    <th class="text-white">Tim Tamu</th>
                    <th class="text-white">Tanggal & Waktu</th>
                    <th class="text-white">Tahap</th>
                    <th class="text-white">Status</th>
                    <th class="text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($matches as $m)
                <tr>
                    <td class="ps-4 text-muted small">{{ $m->id }}</td>
                    <td class="fw-semibold small" style="color:#0a1628;">{{ $m->homeTeam->name }}</td>
                    <td class="fw-semibold small" style="color:#0a1628;">{{ $m->awayTeam->name }}</td>
                    <td class="small">
                        <div>{{ $m->match_date->format('d M Y') }}</div>
                        <div class="text-muted">{{ $m->match_date->format('H:i') }} WIB</div>
                    </td>
                    <td><span class="badge bg-navy" style="font-size:0.7rem;">{{ $m->stage }}</span></td>
                    <td>
                        @php $statusColors = ['Mendatang'=>'info','Berlangsung'=>'warning','Selesai'=>'success','Ditunda'=>'secondary']; @endphp
                        <span class="badge bg-{{ $statusColors[$m->status] ?? 'secondary' }}">{{ $m->status }}</span>
                        @if($m->status === 'Selesai')
                        <div class="text-muted" style="font-size:0.72rem;">{{ $m->home_score }} – {{ $m->away_score }}</div>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.pertandingan.edit', $m->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pertandingan.delete', $m->id) }}" onsubmit="return confirm('Hapus pertandingan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-futbol fa-2x mb-2 d-block"></i> Belum ada data pertandingan
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($matches->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        {{ $matches->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0" style="background:#0a1628;">
                <h5 class="modal-title text-white oswald"><i class="fas fa-plus me-2"></i> Tambah Pertandingan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.pertandingan.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tim Tuan Rumah <span class="text-danger">*</span></label>
                            <select name="home_team_id" class="form-select" required>
                                <option value="">-- Pilih Tim --</option>
                                @foreach($teams as $t)
                                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->group_name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tim Tamu <span class="text-danger">*</span></label>
                            <select name="away_team_id" class="form-select" required>
                                <option value="">-- Pilih Tim --</option>
                                @foreach($teams as $t)
                                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->group_name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal & Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="match_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Venue / Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="venue" class="form-control" placeholder="cth: Stadion Siliwangi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tahap Pertandingan <span class="text-danger">*</span></label>
                            <input type="text" name="stage" class="form-control" placeholder="cth: Grup A - Pekan 1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status" class="form-select">
                                <option value="Mendatang">Mendatang</option>
                                <option value="Berlangsung">Berlangsung</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditunda">Ditunda</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-green fw-bold"><i class="fas fa-save me-1"></i> Simpan Pertandingan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
