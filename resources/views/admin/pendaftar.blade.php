@extends('layouts.admin')
@section('page-title', 'Data Pendaftar')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Data Pendaftar</h4>
        <p class="text-muted small mb-0">Seluruh peserta yang telah mendaftar ke turnamen</p>
    </div>
</div>

<!-- FILTER -->
<div class="card border-0 card-karta mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.pendaftar') }}" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Pilih Kecamatan / Tim</label>
                <select name="search" class="form-select">
                    <option value="">Semua Kecamatan (30 Kecamatan)</option>
                    @foreach([
                        'Andir', 'Antapani', 'Arcamanik', 'Astana Anyar', 'Babakan Ciparay',
                        'Bandung Kidul', 'Bandung Kulon', 'Bandung Wetan', 'Batununggal', 'Bojongloa Kaler',
                        'Bojongloa Kidul', 'Buahbatu', 'Cibeunying Kaler', 'Cibeunying Kidul', 'Cibiru',
                        'Cicendo', 'Cidadap', 'Cinambo', 'Coblong', 'Gedebage',
                        'Kiaracondong', 'Lengkong', 'Mandalajati', 'Panyileukan', 'Rancasari',
                        'Regol', 'Sukajadi', 'Sukasari', 'Sumur Bandung', 'Ujungberung'
                    ] as $kec)
                        <option value="{{ $kec }}" {{ request('search') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Filter Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Verifikasi" {{ request('status')==='Menunggu Verifikasi'?'selected':'' }}>Menunggu Verifikasi</option>
                    <option value="Terverifikasi" {{ request('status')==='Terverifikasi'?'selected':'' }}>Terverifikasi</option>
                    <option value="Ditolak" {{ request('status')==='Ditolak'?'selected':'' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-navy w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                <a href="{{ route('admin.pendaftar') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card border-0 card-karta">
    <div class="card-header border-0 bg-white py-3 d-flex align-items-center justify-content-between">
        <span class="fw-bold small" style="color:#0a1628;">{{ $registrations->total() }} Pendaftar Ditemukan</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="standings-table">
                    <th class="text-white text-center ps-4" style="width:50px;">#</th>
                    <th class="text-white">Nama Peserta</th>
                    <th class="text-white">Kecamatan</th>
                    <th class="text-white">Tanggal Daftar</th>
                    <th class="text-white">Status</th>
                    <th class="text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $i => $reg)
                <tr>
                    <td class="text-center ps-4 text-muted small">{{ $registrations->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-weight:700;color:#0a1628;font-size:0.85rem;flex-shrink:0;">
                                {{ strtoupper(substr($reg->nama_tim, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small" style="color:#0a1628;">{{ $reg->nama_tim }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $reg->user->name }} ({{ $reg->user->email }})</div>
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $reg->kecamatan }}</td>
                    <td class="small text-muted">{{ $reg->created_at->format('d M Y') }}</td>
                    <td>
                        @php $sc = ['Terverifikasi'=>'success','Menunggu Verifikasi'=>'warning','Ditolak'=>'danger','Belum Mendaftar'=>'secondary']; @endphp
                        <span class="badge-status status-{{ strtolower(str_replace(' ','',explode(' ',$reg->status)[0])) }}">{{ $reg->status }}</span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.verifikasi.detail', $reg->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="fas fa-eye me-1"></i> Detail
                            </a>
                            <form method="POST" action="{{ route('admin.pendaftar.destroy', $reg->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran tim {{ $reg->nama_tim }} ini? Data berkas dan anggota akan dihapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pendaftar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">
                    <i class="fas fa-search fa-2x mb-2 d-block"></i>
                    Tidak ada data pendaftar yang ditemukan.
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($registrations->hasPages())
    <div class="card-footer bg-white border-top-0 d-flex justify-content-center py-3">
        {{ $registrations->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
