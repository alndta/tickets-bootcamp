{{-- ============================================ --}}
{{-- XSS LAB: Stored XSS - VULNERABLE --}}
{{-- ⚠️ JANGAN GUNAKAN DI PRODUCTION! --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Stored XSS - Vulnerable')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Stored XSS - Vulnerable</li>
        </ol>
    </nav>

    <div class="alert alert-danger">
        <h5><i class="bi bi-exclamation-triangle"></i> HALAMAN VULNERABLE</h5>
        <p class="mb-0">
            Komentar yang disubmit akan disimpan di database dan ditampilkan 
            <strong>TANPA escaping</strong>. XSS payload akan dieksekusi setiap kali halaman dibuka!
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Ticket Info --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-ticket"></i> 
                        Tiket: {{ $ticket->title ?? 'Sample Ticket' }}
                    </h5>
                </div>
                <div class="card-body">
                    <p>{{ $ticket->description ?? 'Deskripsi tiket untuk demo stored XSS.' }}</p>
                </div>
            </div>

            {{-- Form Komentar --}}
            <div class="card border-danger mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots"></i> Tambah Komentar (VULNERABLE)
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('xss-lab.stored.vulnerable.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id ?? 1 }}">
                        
                        <div class="mb-3">
                            <label for="author_name" class="form-label">Nama</label>
                            <input type="text" name="author_name" id="author_name" 
                                   class="form-control" required
                                   placeholder="Masukkan nama Anda">
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Komentar</label>
                            <textarea name="content" id="content" rows="3" 
                                      class="form-control" required
                                      placeholder="Tulis komentar Anda..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-send"></i> Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Daftar Komentar --}}
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text"></i> 
                        Komentar ({{ $comments->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($comments as $comment)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>
                                    {{-- ❌ VULNERABLE! Nama tanpa escape --}}
                                    {!! $comment->author_name !!}
                                </strong>
                                <small class="text-muted">
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="mt-2">
                                {{-- ❌ VULNERABLE! Konten tanpa escape --}}
                                {!! $comment->content !!}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">
                            <i class="bi bi-chat"></i> Belum ada komentar.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Kode Vulnerable --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Vulnerable</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>@foreach($comments as $comment)
    &lt;div&gt;
        {{-- ❌ VULNERABLE! --}}
        &lt;strong&gt;{!! $comment->author_name !!}&lt;/strong&gt;
        &lt;p&gt;{!! $comment->content !!}&lt;/p&gt;
    &lt;/div&gt;
@endforeach

{{-- Jika user menyimpan: &lt;script&gt;alert('XSS')&lt;/script&gt; --}}
{{-- Script akan dieksekusi SETIAP KALI halaman dibuka! --}}
{{-- SEMUA pengunjung akan terkena! --}}</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Testing Guide --}}
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Cara Testing</h6>
                </div>
                <div class="card-body">
                    <p>Coba submit komentar dengan payload:</p>
                    
                    <div class="mb-3">
                        <small class="text-muted">Di field Nama:</small>
                        <code class="d-block bg-light p-2 rounded small">
                            Hacker&lt;img src=x onerror=alert('Name XSS')&gt;
                        </code>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Di field Komentar:</small>
                        <code class="d-block bg-light p-2 rounded small">
                            Komentar&lt;script&gt;alert('Content XSS')&lt;/script&gt;
                        </code>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-warning small mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Berbahaya!</strong> Payload tersimpan di database 
                        dan akan menyerang SEMUA pengunjung halaman ini!
                    </div>
                </div>
            </div>

            {{-- Link ke versi aman --}}
            <div class="card mt-3 border-success">
                <div class="card-body text-center">
                    <p class="mb-2">Lihat versi yang sudah diperbaiki:</p>
                    <a href="{{ route('xss-lab.stored.secure') }}" class="btn btn-success">
                        <i class="bi bi-shield-check"></i> Versi Secure
                    </a>
                </div>
            </div>

            {{-- Reset --}}
            <div class="card mt-3">
                <div class="card-body text-center">
                    <p class="small text-muted mb-2">
                        Ingin reset komentar?
                    </p>
                    <form action="{{ route('xss-lab.reset-comments') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-trash"></i> Hapus Semua Komentar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
