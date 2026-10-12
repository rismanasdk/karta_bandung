@extends('layouts.admin')
@section('page-title', isset($article) ? 'Edit Artikel' : 'Buat Artikel Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.berita') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
</div>

<form method="POST" action="{{ isset($article) ? route('admin.berita.update', $article->id) : route('admin.berita.store') }}">
    @csrf
    @if(isset($article)) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 card-karta mb-4">
                <div class="card-header border-0 bg-white py-3">
                    <h6 class="fw-bold mb-0" style="color:#0a1628;">Isi Artikel</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Masukkan judul yang menarik..." value="{{ old('title', $article->title ?? '') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Ringkasan <span class="text-danger">*</span></label>
                        <textarea name="summary" class="form-control @error('summary') is-invalid @enderror"
                                  rows="2" placeholder="Ringkasan singkat artikel (maks. 300 karakter)..." required>{{ old('summary', $article->summary ?? '') }}</textarea>
                        @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Isi Lengkap Artikel <span class="text-danger">*</span></label>
                        <textarea name="content" id="contentEditor" class="form-control @error('content') is-invalid @enderror"
                                  rows="12" placeholder="Tulis konten lengkap di sini...">{{ old('content', $article->content ?? '') }}</textarea>
                        <div class="form-text text-muted">Anda dapat menggunakan tag HTML sederhana untuk format teks.</div>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 card-karta mb-4">
                <div class="card-header border-0 bg-white py-3">
                    <h6 class="fw-bold mb-0" style="color:#0a1628;">Pengaturan Publikasi</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Kategori <span class="text-danger">*</span></label>
                        <select name="category" class="form-select" required>
                            <option value="Pengumuman" {{ old('category', $article->category ?? '') === 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            <option value="Berita" {{ old('category', $article->category ?? '') === 'Berita' ? 'selected' : '' }}>Berita</option>
                            <option value="Peraturan" {{ old('category', $article->category ?? '') === 'Peraturan' ? 'selected' : '' }}>Peraturan</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="isPublished" value="1"
                               {{ old('is_published', $article->is_published ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold small" for="isPublished">Terbitkan Sekarang</label>
                        <div class="form-text text-muted" style="font-size:0.72rem;">Jika tidak dicentang, artikel disimpan sebagai draf.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-green fw-bold">
                            <i class="fas fa-save me-2"></i> {{ isset($article) ? 'Perbarui Artikel' : 'Simpan & Terbitkan' }}
                        </button>
                        <a href="{{ route('admin.berita') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </div>

            @if(isset($article))
            <div class="card border-0 card-karta">
                <div class="card-body">
                    <div class="d-flex flex-column gap-2 small">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Dibuat</span>
                            <span class="fw-semibold">{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Terakhir Diubah</span>
                            <span class="fw-semibold">{{ $article->updated_at->format('d M Y') }}</span>
                        </div>
                        @if($article->published_at)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Diterbitkan</span>
                            <span class="fw-semibold text-success">{{ $article->published_at->format('d M Y') }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Penulis</span>
                            <span class="fw-semibold">{{ $article->author->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                    <hr>
                    <a href="{{ route('berita.detail', $article->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-external-link-alt me-1"></i> Lihat di Website
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</form>
@endsection
