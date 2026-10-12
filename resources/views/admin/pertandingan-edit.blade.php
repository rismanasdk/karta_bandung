@extends('layouts.admin')
@section('page-title', 'Edit Pertandingan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pertandingan') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pertandingan
    </a>
</div>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 card-karta">
            <div class="card-header border-0 bg-white py-3">
                <h5 class="oswald fw-bold mb-0" style="color:#0a1628;"><i class="fas fa-edit text-success me-2"></i> Edit Pertandingan</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.pertandingan.update', $match->id) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tim Tuan Rumah <span class="text-danger">*</span></label>
                            <select name="home_team_id" class="form-select" required>
                                @foreach($teams as $t)
                                <option value="{{ $t->id }}" {{ $match->home_team_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tim Tamu <span class="text-danger">*</span></label>
                            <select name="away_team_id" class="form-select" required>
                                @foreach($teams as $t)
                                <option value="{{ $t->id }}" {{ $match->away_team_id == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal & Waktu <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="match_date" class="form-control"
                                   value="{{ $match->match_date->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Venue / Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="venue" class="form-control" value="{{ $match->venue }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tahap Pertandingan <span class="text-danger">*</span></label>
                            <input type="text" name="stage" class="form-control" value="{{ $match->stage }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Status</label>
                            <select name="status" class="form-select">
                                @foreach(['Mendatang','Berlangsung','Selesai','Ditunda'] as $s)
                                <option value="{{ $s }}" {{ $match->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($match->status === 'Selesai')
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Skor Tuan Rumah</label>
                            <input type="number" name="home_score" class="form-control text-center" value="{{ $match->home_score }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold small">Skor Tamu</label>
                            <input type="number" name="away_score" class="form-control text-center" value="{{ $match->away_score }}" min="0">
                        </div>
                        @endif
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2">{{ $match->notes }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-green fw-bold px-4"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                        <a href="{{ route('admin.pertandingan') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
