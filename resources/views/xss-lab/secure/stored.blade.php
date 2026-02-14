{{-- ============================================ --}}
{{-- XSS LAB: Stored XSS - SECURE --}}
{{-- ✅ Versi yang sudah diamankan --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Stored XSS - Secure')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Stored XSS - Secure</li>
        </ol>
    </nav>

    <div class="alert alert-success">
        <h5><i class="bi bi-shield-check"></i> HALAMAN SECURE</h5>
        <p class="mb-0">
            Komentar ditampilkan dengan Blade auto-escape @{{ }}. 
            Script berbahaya akan ditampilkan sebagai teks biasa.
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
            <div class="card border-success mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots"></i> Tambah Komentar (SECURE)
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('xss-lab.stored.secure.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id ?? 1 }}">
                        
                        <div class="mb-3">
                            <label for="author_name" class="form-label">Nama</label>
                            <input type="text" name="author_name" id="author_name" 
                                   class="form-control @error('author_name') is-invalid @enderror" 
                                   required maxlength="100"
                                   value="{{ old('author_name') }}"
                                   placeholder="Masukkan nama Anda">
                            @error('author_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Komentar</label>
                            <textarea name="content" id="content" rows="3" 
                                      class="form-control @error('content') is-invalid @enderror" 
                                      required maxlength="1000"
                                      placeholder="Tulis komentar Anda...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send"></i> Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Daftar Komentar --}}
            <div class="card border-success">
                <div class="card-header bg-success text-white">
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
                                    {{-- ✅ SECURE! Auto-escape dengan {{ }} --}}
                                    {{ $comment->author_name }}
                                </strong>
                                <small class="text-muted">
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="mt-2">
                                {{-- ✅ SECURE! Auto-escape dengan {{ }} --}}
                                {{-- nl2br + e() untuk preserve line breaks dengan aman --}}
                                {!! nl2br(e($comment->content)) !!}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">
                            <i class="bi bi-chat"></i> Belum ada komentar.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Kode Secure --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Secure</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>@foreach($comments as $comment)
    &lt;div&gt;
        {{-- ✅ SECURE! Auto-escape --}}
        &lt;strong&gt;@{{ $comment->author_name }}&lt;/strong&gt;
        
        {{-- ✅ SECURE! nl2br() + e() untuk line breaks --}}
        &lt;p&gt;{!! nl2br(e($comment->content)) !!}&lt;/p&gt;
    &lt;/div&gt;
@endforeach

{{-- e() adalah shortcut untuk htmlspecialchars() --}}
{{-- nl2br() mengkonversi newlines ke &lt;br&gt; --}}
{{-- Kombinasi keduanya: line breaks tetap ada, tapi aman dari XSS --}}</code></pre>
                </div>
            </div>

            {{-- Validation di Controller --}}
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-shield"></i> Validasi di Controller</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>// ✅ SECURE: Validasi input
$validated = $request->validate([
    'ticket_id' => 'required|exists:tickets,id',
    'author_name' => 'required|string|max:100',
    'content' => 'required|string|max:1000',
]);

// Simpan data yang sudah divalidasi
Comment::create($validated);

// Blade akan otomatis escape saat menampilkan</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Testing Guide --}}
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Cara Testing</h6>
                </div>
                <div class="card-body">
                    <p>Coba submit payload yang sama:</p>
                    
                    <div class="mb-3">
                        <code class="d-block bg-light p-2 rounded small">
                            &lt;script&gt;alert('XSS')&lt;/script&gt;
                        </code>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-success small mb-0">
                        <i class="bi bi-check-circle"></i>
                        <strong>Aman!</strong> Script akan ditampilkan 
                        sebagai TEKS biasa, tidak dieksekusi.
                    </div>
                </div>
            </div>

            {{-- Link ke versi vulnerable --}}
            <div class="card mt-3 border-danger">
                <div class="card-body text-center">
                    <p class="mb-2">Bandingkan dengan versi vulnerable:</p>
                    <a href="{{ route('xss-lab.stored.vulnerable') }}" class="btn btn-outline-danger">
                        <i class="bi bi-unlock"></i> Versi Vulnerable
                    </a>
                </div>
            </div>

            {{-- Best Practices --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-bookmark"></i> Best Practices</h6>
                </div>
                <div class="card-body small">
                    <ul class="mb-0">
                        <li>Validasi semua input di server</li>
                        <li>Gunakan <code>@{{ }}</code> untuk output</li>
                        <li>Gunakan <code>e()</code> jika perlu <code>nl2br()</code></li>
                        <li>Set <code>maxlength</code> di form dan validasi</li>
                        <li>Pertimbangkan HTML Purifier untuk rich text</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
