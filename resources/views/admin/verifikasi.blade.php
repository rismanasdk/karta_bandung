@extends('layouts.admin')
@section('page-title', 'Verifikasi Peserta')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Verifikasi Peserta</h4>
        <p class="text-muted small mb-0">Periksa dan verifikasi dokumen peserta yang mendaftar</p>
    </div>
    <span class="badge bg-warning text-dark fs-6">{{ $registrations->total() }} Menunggu</span>
</div>

<div class="card border-0 card-karta">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="standings-table">
                    <th class="text-white ps-4">Nama Peserta</th>
                    <th class="text-white">Kecamatan</th>
                    <th class="text-white">Tanggal Daftar</th>
                    <th class="text-white">Dokumen</th>
                    <th class="text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:38px;height:38px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-weight:700;color:#92400e;">
                                {{ strtoupper(substr($reg->nama_tim, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold small" style="color:#0a1628;">{{ $reg->nama_tim }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $reg->user->name }} ({{ $reg->user->email }})</div>
                            </div>
                        </div>
                    </td>
                    <td class="small">{{ $reg->kecamatan }}</td>
                    <td class="small text-muted">{{ $reg->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-column">
                            <span class="badge bg-primary" style="font-size:0.68rem;">
                                <i class="fas fa-users me-1"></i> {{ $reg->members()->where('tipe', 'pemain')->count() }} Pemain
                            </span>
                            <span class="badge bg-info" style="font-size:0.68rem;">
                                <i class="fas fa-user-tie me-1"></i> {{ $reg->members()->where('tipe', 'official')->count() }} Official
                            </span>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.verifikasi.detail', $reg->id) }}" class="btn btn-sm btn-warning text-white">
                            <i class="fas fa-search me-1"></i> Periksa
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-5 text-muted">
                    <i class="fas fa-check-circle fa-3x text-success mb-3 d-block"></i>
                    <strong>Semua pendaftar sudah diverifikasi!</strong><br>
                    <small>Tidak ada yang menunggu verifikasi saat ini.</small>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($registrations->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        {{ $registrations->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
