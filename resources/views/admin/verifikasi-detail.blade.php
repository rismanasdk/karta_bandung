@extends('layouts.admin')
@section('page-title', 'Detail Verifikasi – ' . $registration->nama_tim)

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.verifikasi') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="{{ route('admin.verifikasi.cetak', $registration->id) }}" target="_blank" class="btn btn-outline-primary btn-sm fw-semibold">
            <i class="fas fa-print me-1"></i> Cetak / Export PDF
        </a>
    </div>
    
    @if($registration->status === 'Menunggu Verifikasi')
    <div class="d-flex gap-2">
        <button class="btn btn-danger btn-sm" data-bs-toggle="collapse" data-bs-target="#formTolak">
            <i class="fas fa-times me-1"></i> Tolak
        </button>
        <form method="POST" action="{{ route('admin.verifikasi.terima', $registration->id) }}" onsubmit="return confirm('Yakin menerima pendaftaran tim {{ $registration->nama_tim }}?')">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-check me-1"></i> Terima Pendaftaran
            </button>
        </form>
    </div>
    @endif
</div>

@if($registration->status === 'Menunggu Verifikasi')
<div class="collapse mb-4" id="formTolak">
    <div class="card border-0 card-karta">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.verifikasi.tolak', $registration->id) }}" onsubmit="return confirm('Yakin menolak pendaftaran ini?')">
                @csrf
                <label class="form-label fw-semibold small">Alasan Penolakan <span class="text-danger">*</span></label>
                <textarea name="rejection_reason" class="form-control mb-3" rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-ban me-1"></i> Kirim Penolakan</button>
            </form>
        </div>
    </div>
</div>
@endif

<div class="row g-4">
    <!-- DATA TIM -->
    <div class="col-lg-12">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-shield-alt text-success me-2"></i> Data Tim</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <span class="text-muted small d-block">Nama Tim</span>
                        <span class="fw-bold">{{ $registration->nama_tim }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">Kecamatan</span>
                        <span class="fw-bold">{{ $registration->kecamatan }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">Surat Rekomendasi</span>
                        @if($registration->surat_rekomendasi_path)
                            <a href="{{ asset('storage/' . $registration->surat_rekomendasi_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2 mt-1">
                                <i class="fas fa-file-pdf me-1"></i> Lihat Dokumen
                            </a>
                        @else
                            <span class="badge bg-secondary">Belum Upload</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block">Status</span>
                        <span class="badge-status status-{{ strtolower(str_replace(' ','',explode(' ',$registration->status)[0])) }}">{{ $registration->status }}</span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-muted small d-block">Akun Pendaftar</span>
                        <span class="fw-bold">{{ $registration->user->name }} ({{ $registration->user->email }})</span>
                    </div>
                </div>
                @if($registration->rejection_reason)
                <div class="mt-3 p-2 rounded" style="background:#fff1f2;border:1px solid #fecaca;">
                    <span class="text-danger small"><strong>Alasan Ditolak:</strong> {{ $registration->rejection_reason }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- DATA OFFICIAL -->
    <div class="col-lg-12">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-user-tie text-info me-2"></i> Data Official</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-muted py-3 px-4">Nama Lengkap</th>
                                <th class="small text-muted py-3">Jabatan</th>
                                <th class="small text-muted py-3">NIK & Tgl Lahir</th>
                                <th class="small text-muted py-3">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registration->members()->where('tipe', 'official')->get() as $off)
                            <tr>
                                <td class="px-4 fw-medium">{{ $off->full_name }}</td>
                                <td>{{ $off->jabatan }}</td>
                                <td>
                                    <div>{{ $off->nik }}</div>
                                    <small class="text-muted">{{ $off->tanggal_lahir->format('d M Y') }}</small>
                                </td>
                                <td>
                                    @if($off->pasfoto_path)<a href="{{ Storage::url($off->pasfoto_path) }}" target="_blank" download class="badge bg-secondary text-decoration-none" title="Klik untuk lihat / unduh"><i class="fas fa-image me-1"></i>Pas Foto</a>@endif
                                    @if($off->ktp_path)<a href="{{ Storage::url($off->ktp_path) }}" target="_blank" download class="badge bg-primary text-decoration-none" title="Klik untuk lihat / unduh"><i class="fas fa-id-card me-1"></i>KTP</a>@endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-3 text-muted">Belum ada official</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DATA PEMAIN -->
    <div class="col-lg-12">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-users text-primary me-2"></i> Data Pemain</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small text-muted py-3 px-4">No.</th>
                                <th class="small text-muted py-3">Nama Pemain</th>
                                <th class="small text-muted py-3">Posisi</th>
                                <th class="small text-muted py-3">NIK & Tgl Lahir</th>
                                <th class="small text-muted py-3">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registration->members()->where('tipe', 'pemain')->get() as $pem)
                            <tr>
                                <td class="px-4 fw-bold text-center" style="width:50px;">{{ $pem->nomor_punggung }}</td>
                                <td class="fw-medium">{{ $pem->full_name }}</td>
                                <td>{{ $pem->posisi }}</td>
                                <td>
                                    <div>{{ $pem->nik }}</div>
                                    <small class="text-muted">{{ $pem->tanggal_lahir->format('d M Y') }}</small>
                                </td>
                                <td>
                                    @if($pem->pasfoto_path)<a href="{{ Storage::url($pem->pasfoto_path) }}" target="_blank" download class="badge bg-secondary text-decoration-none mb-1 d-inline-block" title="Klik untuk lihat / unduh"><i class="fas fa-image me-1"></i>Pas Foto</a>@endif
                                    @if($pem->ktp_path)<a href="{{ Storage::url($pem->ktp_path) }}" target="_blank" download class="badge bg-primary text-decoration-none mb-1 d-inline-block" title="Klik untuk lihat / unduh"><i class="fas fa-id-card me-1"></i>KTP</a>@endif
                                    @if($pem->kk_path)<a href="{{ Storage::url($pem->kk_path) }}" target="_blank" download class="badge bg-success text-decoration-none mb-1 d-inline-block" title="Klik untuk lihat / unduh"><i class="fas fa-file-alt me-1"></i>KK</a>@endif
                                    @if($pem->surat_sehat_path)<a href="{{ Storage::url($pem->surat_sehat_path) }}" target="_blank" download class="badge bg-info text-dark text-decoration-none mb-1 d-inline-block" title="Surat keterangan sehat"><i class="fas fa-heartbeat me-1"></i>Surat Sehat</a>@endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
