{{-- ============================================ --}}
{{-- XSS LAB: Reflected XSS - SECURE --}}
{{-- ✅ Versi yang sudah diamankan --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Reflected XSS - Secure')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Reflected XSS - Secure</li>
        </ol>
    </nav>

    <div class="alert alert-success">
        <h5><i class="bi bi-shield-check"></i> HALAMAN SECURE</h5>
        <p class="mb-0">
            Halaman ini menggunakan Blade auto-escape @{{ }} untuk mencegah XSS.
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-search"></i> Pencarian Tiket (SECURE)
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('xss-lab.reflected.secure') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari tiket..."
                                   value="{{ $searchQuery }}">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- ============================================ --}}
                    {{-- SECURE CODE! --}}
                    {{-- Menggunakan {{ }} untuk auto-escape --}}
                    {{-- ============================================ --}}
                    @if($searchQuery)
                        <div class="alert alert-secondary">
                            <strong>Hasil pencarian untuk:</strong>
                            {{-- ✅ SECURE! Blade auto-escape dengan {{ }} --}}
                            {{ $searchQuery }}
                        </div>
                    @endif

                    {{-- Contoh hasil pencarian --}}
                    <p class="text-muted">
                        (Tidak ada hasil ditemukan - ini hanya demo)
                    </p>
                </div>
            </div>

            {{-- Penjelasan Keamanan --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Secure</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>{{-- ✅ SECURE CODE --}}
&lt;div class="alert"&gt;
    Hasil pencarian untuk: @{{ $searchQuery }}
&lt;/div&gt;

{{-- Blade otomatis memanggil htmlspecialchars() --}}
{{-- Jika user memasukkan: &lt;script&gt;alert('XSS')&lt;/script&gt; --}}
{{-- Output: &amp;lt;script&amp;gt;alert('XSS')&amp;lt;/script&amp;gt; --}}
{{-- Browser menampilkan sebagai TEKS, tidak dieksekusi! --}}</code></pre>
                </div>
            </div>

            {{-- Perbandingan --}}
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-arrow-left-right"></i> Perbandingan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">❌ Vulnerable:</h6>
                            <pre class="bg-light p-2 rounded"><code>@{!! $searchQuery !!}</code></pre>
                            <p class="small text-muted">
                                User input langsung di-render tanpa escape
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Secure:</h6>
                            <pre class="bg-light p-2 rounded"><code>@{{ $searchQuery }}</code></pre>
                            <p class="small text-muted">
                                Blade auto-escape mencegah eksekusi script
                            </p>
                        </div>
                    </div>
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
                    <p>Coba masukkan payload yang sama:</p>
                    
                    <div class="mb-2">
                        <code class="d-block bg-light p-2 rounded">&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                    </div>
                    
                    <hr>
                    
                    <p class="small text-success mb-0">
                        <i class="bi bi-check-circle"></i>
                        Script akan ditampilkan sebagai <strong>TEKS</strong>, 
                        bukan dieksekusi!
                    </p>
                </div>
            </div>

            {{-- Link ke versi vulnerable --}}
            <div class="card mt-3 border-danger">
                <div class="card-body text-center">
                    <p class="mb-2">Bandingkan dengan versi vulnerable:</p>
                    <a href="{{ route('xss-lab.reflected.vulnerable') }}" class="btn btn-outline-danger">
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
                        <li>Selalu gunakan <code>@{{ }}</code> untuk output</li>
                        <li>Hindari <code>@{!! !!}</code> untuk user input</li>
                        <li>Validasi input di server</li>
                        <li>Gunakan Content Security Policy</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
