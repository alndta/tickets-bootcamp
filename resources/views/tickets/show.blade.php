{{-- ============================================ --}}
{{-- Tickets Show - dengan Comments --}}
{{-- View untuk menampilkan detail ticket beserta komentar --}}
{{-- Implementasi XSS Prevention yang benar --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', $ticket->title . ' - Ticket Detail')

@push('styles')
<style>
    .comment-card {
        transition: background-color 0.2s ease;
    }
    .comment-card:hover {
        background-color: #f8f9fa;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    .priority-high { border-left: 4px solid #dc3545; }
    .priority-medium { border-left: 4px solid #ffc107; }
    .priority-low { border-left: 4px solid #28a745; }
</style>
@endpush

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('tickets.index') }}">Tickets</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{-- ✅ SAFE: Auto-escaped --}}
                {{ $ticket->title }}
            </li>
        </ol>
    </nav>

    <div class="row">
        {{-- ============================================ --}}
        {{-- TICKET DETAIL --}}
        {{-- ============================================ --}}
        <div class="col-lg-8">
            <div class="card mb-4 priority-{{ $ticket->priority ?? 'medium' }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">
                            {{-- ✅ SAFE: Auto-escaped --}}
                            {{ $ticket->title }}
                        </h4>
                        <small class="text-muted">
                            Ticket #{{ $ticket->id }}
                        </small>
                    </div>
                    <div>
                        {{-- Status Badge --}}
                        @php
                            $statusColors = [
                                'open' => 'success',
                                'in_progress' => 'warning',
                                'closed' => 'secondary',
                            ];
                            $statusColor = $statusColors[$ticket->status] ?? 'primary';
                        @endphp
                        <span class="badge bg-{{ $statusColor }} status-badge">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        
                        {{-- Priority Badge --}}
                        @php
                            $priorityColors = [
                                'high' => 'danger',
                                'medium' => 'warning',
                                'low' => 'success',
                            ];
                            $priorityColor = $priorityColors[$ticket->priority ?? 'medium'] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $priorityColor }} status-badge">
                            {{ ucfirst($ticket->priority ?? 'Medium') }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    {{-- ✅ SAFE: Auto-escaped, nl2br untuk preserve line breaks --}}
                    <div class="ticket-description mb-4">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-person"></i>
                            Dibuat oleh 
                            <strong>{{ $ticket->user->name ?? 'Unknown' }}</strong>
                            pada {{ $ticket->created_at->format('d M Y, H:i') }}
                        </small>
                        
                        @if($ticket->user_id === auth()->id())
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tickets.edit', $ticket) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('tickets.destroy', $ticket) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus ticket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- FORM TAMBAH KOMENTAR --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots"></i> Tambah Komentar
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('comments.store', $ticket) }}" method="POST">
                        {{-- ✅ CSRF Protection --}}
                        @csrf
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Komentar</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="3" 
                                class="form-control @error('content') is-invalid @enderror"
                                placeholder="Tulis komentar Anda di sini..."
                                required
                                minlength="3"
                                maxlength="2000"
                            >{{ old('content') }}</textarea>
                            
                            @error('content')
                                {{-- ✅ SAFE: $message dari Laravel sudah sanitized --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i>
                                Minimal 3 karakter, maksimal 2000 karakter.
                                <span class="text-warning">
                                    HTML tags akan dihapus untuk keamanan.
                                </span>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Kirim Komentar
                            </button>
                            
                            {{-- Security Context Button --}}
                            <button type="button" 
                                    class="btn btn-outline-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#securityModal">
                                <i class="bi bi-shield-check"></i> Security Info
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- DAFTAR KOMENTAR --}}
            {{-- ============================================ --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-square-text"></i> 
                        Komentar ({{ $ticket->comments->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($ticket->comments as $comment)
                        <div class="comment-card border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                         style="width: 40px; height: 40px;">
                                        {{-- ✅ SAFE: strtoupper & substr pada escaped value --}}
                                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $comment->user->name ?? 'Unknown User' }}</strong>
                                        @if($comment->user_id === $ticket->user_id)
                                            <span class="badge bg-info text-dark ms-1">Author</span>
                                        @endif
                                        <br>
                                        <small class="text-muted">
                                            {{ $comment->created_at->diffForHumans() }}
                                            <span class="ms-2">
                                                {{ $comment->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                
                                {{-- Delete Button (hanya untuk owner atau admin) --}}
                                @if(auth()->id() === $comment->user_id || (auth()->user()->is_admin ?? false))
                                    <form action="{{ route('comments.destroy', $comment) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus komentar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            {{-- Comment Content --}}
                            <div class="comment-content ps-5">
                                {{-- ✅ SAFE: nl2br untuk line breaks, e() untuk escaping --}}
                                {{-- Ini adalah defense in depth: --}}
                                {{-- 1. Input sudah di-strip_tags() saat disimpan --}}
                                {{-- 2. Output di-escape dengan e() saat ditampilkan --}}
                                {!! nl2br(e($comment->content)) !!}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-chat-square display-4"></i>
                            <p class="mt-3">Belum ada komentar.</p>
                            <p class="small">Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- SIDEBAR --}}
        {{-- ============================================ --}}
        <div class="col-lg-4">
            {{-- Quick Actions --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </a>
                        @if($ticket->status !== 'closed')
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit Ticket
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Ticket Info --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Ticket</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-{{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Priority</span>
                        <span class="badge bg-{{ $priorityColor }}">
                            {{ ucfirst($ticket->priority ?? 'Medium') }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Dibuat</span>
                        <span>{{ $ticket->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Update Terakhir</span>
                        <span>{{ $ticket->updated_at->diffForHumans() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Jumlah Komentar</span>
                        <span class="badge bg-secondary">{{ $ticket->comments->count() }}</span>
                    </li>
                </ul>
            </div>

            {{-- Security Info Card --}}
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-shield-check"></i> Security Features
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 small">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            CSRF Protection aktif
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            XSS Prevention (auto-escape)
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            Input Validation
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success"></i>
                            Input Sanitization (strip_tags)
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success"></i>
                            Authorization Check
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Include Security Modal --}}
@include('partials.security-popup')
@endsection

@push('scripts')
<script>
    // Character counter untuk textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('content');
        const maxLength = 2000;
        
        if (textarea) {
            // Create counter element
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            counter.id = 'charCounter';
            textarea.parentNode.appendChild(counter);
            
            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${remaining} karakter tersisa`;
                counter.className = remaining < 100 ? 'form-text text-end text-danger' : 'form-text text-end';
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
</script>
@endpush
