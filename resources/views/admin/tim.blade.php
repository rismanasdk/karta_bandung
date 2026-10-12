@extends('layouts.admin')
@section('page-title', 'Kelola Tim')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Kelola Tim</h4>
        <p class="text-muted small mb-0">Tambah dan atur tim yang berkompetisi</p>
    </div>
    <button class="btn btn-green fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahTim">
        <i class="fas fa-plus me-2"></i> Tambah Tim
    </button>
</div>

<div class="card border-0 card-karta">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="standings-table">
                    <th class="text-white ps-4">#</th>
                    <th class="text-white">Nama Tim</th>
                    <th class="text-white">Kecamatan</th>
                    <th class="text-white">Grup</th>
                    <th class="text-white text-center">Main</th>
                    <th class="text-white text-center">M/S/K</th>
                    <th class="text-white text-center">Poin</th>
                    <th class="text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teams as $i => $t)
                <tr>
                    <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
                    <td>
                        <div class="fw-bold" style="color:#0a1628;">{{ $t->name }}</div>
                    </td>
                    <td class="small text-muted">{{ $t->kecamatan }}</td>
                    <td><span class="badge bg-navy" style="font-size:0.7rem;">{{ $t->group_name }}</span></td>
                    <td class="text-center small">{{ $t->played }}</td>
                    <td class="text-center small">
                        <span class="text-success fw-semibold">{{ $t->won }}</span>/
                        <span>{{ $t->drawn }}</span>/
                        <span class="text-danger">{{ $t->lost }}</span>
                    </td>
                    <td class="text-center fw-bold" style="color:#0a1628;">{{ $t->points }}</td>
                    <td class="text-center">
                        <form method="POST" action="{{ route('admin.tim.delete', $t->id) }}" onsubmit="return confirm('Hapus tim {{ $t->name }}? Semua data pertandingan terkait juga akan terhapus!')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-5 text-muted">
                    <i class="fas fa-shield-alt fa-2x mb-2 d-block"></i> Belum ada tim yang terdaftar.
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH TIM -->
<div class="modal fade" id="modalTambahTim" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0" style="background:#0a1628;">
                <h5 class="modal-title text-white oswald"><i class="fas fa-shield-alt me-2"></i> Tambah Tim Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.tim.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Tim / Kecamatan <span class="text-danger">*</span></label>
                        @php
                            $kecamatanList = [
                                'Andir', 'Antapani', 'Arcamanik', 'Astana Anyar', 'Babakan Ciparay',
                                'Bandung Kidul', 'Bandung Kulon', 'Bandung Wetan', 'Batununggal', 'Bojongloa Kaler',
                                'Bojongloa Kidul', 'Buahbatu', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Cibiru',
                                'Cicendo', 'Cidadap', 'Cinambo', 'Coblong', 'Gedebage',
                                'Kiaracondong', 'Lengkong', 'Mandalajati', 'Panyileukan', 'Rancasari',
                                'Regol', 'Sukajadi', 'Sukasari', 'Sumur Bandung', 'Ujungberung'
                            ];
                        @endphp
                        <select name="name" id="selectNamaTimAdmin" class="form-select" required>
                            <option value="">-- Pilih Nama Kecamatan --</option>
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Grup <span class="text-danger">*</span></label>
                        <select name="group_name" class="form-select" required>
                            <option value="Grup A">Grup A</option>
                            <option value="Grup B">Grup B</option>
                            <option value="Grup C">Grup C</option>
                            <option value="Grup D">Grup D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-green fw-bold"><i class="fas fa-save me-1"></i> Simpan Tim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
