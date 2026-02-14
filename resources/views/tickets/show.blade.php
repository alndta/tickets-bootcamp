{{-- ============================================ --}}
{{-- VIEW: tickets/show.blade.php --}}
{{-- Menampilkan detail satu tiket --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Detail Tiket #' . $ticket->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h3 mb-1">
                    {{-- 
                        PENTING: Menggunakan {{ }} untuk auto-escape
                        Ini mencegah XSS jika title mengandung script berbahaya
                    --}}
                    {{ $ticket->title }}
                </h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge {{ $ticket->status_badge }}">
                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                    </span>
                    <span class="badge {{ $ticket->priority_badge }}">
                        {{ ucfirst($ticket->priority) }} Priority
                    </span>
                    <span class="text-muted">
                        Tiket #{{ $ticket->id }}
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <strong>{{ $ticket->user->name ?? 'Unknown User' }}</strong>
                        <br>
                        <small class="text-muted">
                            Dibuat {{ $ticket->created_at->format('d M Y, H:i') }}
                            ({{ $ticket->created_at->diffForHumans() }})
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="ticket-description">
                    {{-- 
                        KEAMANAN: Menggunakan {{ }} bukan {!! !!}
                        
                        {{ $ticket->description }} akan di-escape sehingga:
                        - <script>alert('XSS')</script> menjadi teks biasa
                        - Tag HTML berbahaya tidak akan dieksekusi
                        
                        Jika Anda HARUS menampilkan HTML (misal dari WYSIWYG editor),
                        gunakan library seperti HTMLPurifier untuk sanitize
                    --}}
                    {!! nl2br(e($ticket->description)) !!}
                </div>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Informasi Tiket
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" style="width: 120px;">ID Tiket</td>
                                <td><strong>#{{ $ticket->id }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    <span class="badge {{ $ticket->status_badge }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Prioritas</td>
                                <td>
                                    <span class="badge {{ $ticket->priority_badge }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" style="width: 120px;">Dibuat oleh</td>
                                <td>{{ $ticket->user->name ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Dibuat pada</td>
                                <td>{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Diupdate pada</td>
                                <td>{{ $ticket->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-warning">
            <div class="card-header bg-warning bg-opacity-25">
                <h6 class="mb-0">
                    <i class="bi bi-gear"></i> Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit Tiket
                    </a>
                    
                    {{-- Quick Status Update Buttons --}}
                    @if($ticket->status !== 'in_progress')
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $ticket->title }}">
                            <input type="hidden" name="description" value="{{ $ticket->description }}">
                            <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-play"></i> Proses
                            </button>
                        </form>
                    @endif

                    @if($ticket->status !== 'closed')
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $ticket->title }}">
                            <input type="hidden" name="description" value="{{ $ticket->description }}">
                            <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                            <input type="hidden" name="status" value="closed">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg"></i> Selesai
                            </button>
                        </form>
                    @endif

                    @if($ticket->status === 'closed')
                        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $ticket->title }}">
                            <input type="hidden" name="description" value="{{ $ticket->description }}">
                            <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                            <input type="hidden" name="status" value="open">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-arrow-counterclockwise"></i> Buka Kembali
                            </button>
                        </form>
                    @endif
                    
                    {{-- Delete Form --}}
                    <form action="{{ route('tickets.destroy', $ticket) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus tiket ini? Aksi ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
