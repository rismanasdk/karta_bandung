@extends('layouts.admin')
@section('page-title', 'Berita & Pengumuman')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Berita & Pengumuman</h4>
        <p class="text-muted small mb-0">Kelola konten berita dan pengumuman turnamen</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-green fw-bold">
        <i class="fas fa-plus me-2"></i> Buat Artikel Baru
    </a>
</div>

<div class="card border-0 card-karta">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="standings-table">
                    <th class="text-white ps-4">#</th>
                    <th class="text-white">Judul</th>
                    <th class="text-white">Kategori</th>
                    <th class="text-white">Status</th>
                    <th class="text-white">Tanggal</th>
                    <th class="text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $i => $n)
                <tr>
                    <td class="ps-4 text-muted small">{{ $news->firstItem() + $i }}</td>
                    <td>
                        <div class="fw-semibold small" style="color:#0a1628;">{{ Str::limit($n->title, 60) }}</div>
                        <div class="text-muted" style="font-size:0.72rem;">{{ Str::limit($n->summary, 80) }}</div>
                    </td>
                    <td>
                        @php $catColor = ['Pengumuman'=>'warning','Berita'=>'info','Peraturan'=>'secondary']; @endphp
                        <span class="badge bg-{{ $catColor[$n->category] ?? 'secondary' }}" style="font-size:0.7rem;">{{ $n->category }}</span>
                    </td>
                    <td>
                        @if($n->is_published)
                            <span class="badge bg-success" style="font-size:0.7rem;"><i class="fas fa-eye me-1"></i> Tayang</span>
                        @else
                            <span class="badge bg-secondary" style="font-size:0.7rem;"><i class="fas fa-eye-slash me-1"></i> Draf</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $n->published_at?->format('d M Y') ?? $n->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.berita.edit', $n->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('berita.detail', $n->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.berita.delete', $n->id) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">
                    <i class="fas fa-newspaper fa-2x mb-2 d-block"></i> Belum ada artikel. Buat artikel pertama!
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($news->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        {{ $news->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
