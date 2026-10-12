@extends('layouts.peserta')
@section('page-title', 'Notifikasi')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="oswald fw-bold mb-0" style="color:#0a1628;">Notifikasi</h4>
        <p class="text-muted small mb-0">Pesan dan pemberitahuan dari panitia turnamen</p>
    </div>
    <div class="d-flex gap-2">
        @if($notifications->where('is_read',false)->count() > 0)
        <form method="POST" action="{{ route('peserta.notifikasi.baca-semua') }}">
            @csrf
            <button type="submit" class="btn btn-outline-success btn-sm">
                <i class="fas fa-check-double me-1"></i> Tandai Semua Dibaca
            </button>
        </form>
        @endif
        @if($notifications->count() > 0)
        <form method="POST" action="{{ route('peserta.notifikasi.destroy-all') }}" onsubmit="return confirm('Hapus semua notifikasi?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-trash-alt me-1"></i> Hapus Semua
            </button>
        </form>
        @endif
    </div>
</div>

<div class="card border-0 card-karta">
    <div class="card-body p-0">
        @forelse($notifications as $notif)
        <div class="d-flex align-items-start gap-3 px-4 py-4 border-bottom position-relative"
             style="{{ !$notif->is_read ? 'background:#f0fdf4;' : '' }}">
            @if(!$notif->is_read)
            <span class="position-absolute" style="top:12px;right:16px;width:8px;height:8px;border-radius:50%;background:#1a9b52;"></span>
            @endif
            <div style="width:42px;height:42px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                background:{{ $notif->type==='verifikasi'?'#dcfce7':($notif->type==='penolakan'?'#fee2e2':'#dbeafe') }};">
                @php $icons = ['verifikasi'=>'fa-check-circle text-success','penolakan'=>'fa-times-circle text-danger','jadwal'=>'fa-calendar text-primary','pengumuman'=>'fa-bullhorn text-warning']; @endphp
                <i class="fas {{ $icons[$notif->type] ?? 'fa-bell text-muted' }}"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold small" style="color:#0a1628;">{{ $notif->title }}</span>
                    <span class="text-muted" style="font-size:0.72rem;">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-muted small mb-0">{{ $notif->message }}</p>
            </div>
            <div class="flex-shrink-0 ms-2">
                <form method="POST" action="{{ route('peserta.notifikasi.destroy', $notif->id) }}" onsubmit="return confirm('Hapus notifikasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-link text-muted p-0" title="Hapus Notifikasi">
                        <i class="fas fa-trash-alt text-danger" style="opacity:0.6;font-size:0.85rem;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-5 text-muted">
            <i class="fas fa-bell-slash fa-3x mb-3 d-block"></i>
            <h6 class="fw-bold">Belum ada notifikasi</h6>
            <p class="small">Notifikasi dari panitia akan muncul di sini.</p>
        </div>
        @endforelse
    </div>
    @if($notifications->hasPages())
    <div class="card-footer bg-white py-3 d-flex justify-content-center">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
