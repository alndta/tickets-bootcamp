{{-- ============================================ --}}
{{-- VIEW: tickets/index.blade.php --}}
{{-- Menampilkan daftar semua tiket --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-ticket-detailed"></i> Daftar Tiket
        </h1>
        <p class="text-muted mb-0">Kelola semua tiket support</p>
    </div>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Buat Tiket Baru
    </a>
</div>

{{-- ============================================ --}}
{{-- TABEL TIKET --}}
{{-- ============================================ --}}
<div class="card">
    <div class="card-body">
        @forelse($tickets as $ticket)
            <div class="d-flex justify-content-between align-items-start border-bottom py-3 
                        {{ $loop->last ? 'border-0 pb-0' : '' }}">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-1">
                        <h5 class="mb-0 me-2">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-decoration-none">
                                {{-- 
                                    PENTING: Menggunakan {{ }} untuk auto-escape 
                                    Mencegah XSS Attack! 
                                --}}
                                {{ $ticket->title }}
                            </a>
                        </h5>
                        <span class="badge {{ $ticket->status_badge }} me-1">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                        <span class="badge {{ $ticket->priority_badge }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </div>
                    <p class="text-muted mb-1">
                        {{-- Truncate description untuk preview --}}
                        {{ Str::limit($ticket->description, 100) }}
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> 
                        {{ $ticket->user->name ?? 'Unknown' }}
                        &bull;
                        <i class="bi bi-clock"></i>
                        {{ $ticket->created_at->diffForHumans() }}
                    </small>
                </div>
                <div class="ms-3">
                    <a href="{{ route('tickets.edit', $ticket) }}" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    {{-- 
                        Form DELETE dengan CSRF Protection
                        @csrf WAJIB ada untuk keamanan!
                        @method('DELETE') karena HTML form hanya support GET/POST 
                    --}}
                    <form action="{{ route('tickets.destroy', $ticket) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin ingin menghapus tiket ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada tiket</p>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Buat Tiket Pertama
                </a>
            </div>
        @endforelse
    </div>
</div>

{{-- Pagination --}}
@if($tickets->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $tickets->links() }}
    </div>
@endif

{{-- ============================================ --}}
{{-- STATISTIK RINGKAS --}}
{{-- ============================================ --}}
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h5 class="card-title">Open</h5>
                <p class="card-text display-6">
                    {{ \App\Models\Ticket::where('status', 'open')->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-info">
            <div class="card-body">
                <h5 class="card-title">In Progress</h5>
                <p class="card-text display-6">
                    {{ \App\Models\Ticket::where('status', 'in_progress')->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">Closed</h5>
                <p class="card-text display-6">
                    {{ \App\Models\Ticket::where('status', 'closed')->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
