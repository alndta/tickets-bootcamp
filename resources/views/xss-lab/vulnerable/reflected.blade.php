{{-- ============================================ --}}
{{-- XSS LAB: Reflected XSS - VULNERABLE --}}
{{-- ⚠️ JANGAN GUNAKAN DI PRODUCTION! --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Reflected XSS - Vulnerable')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Reflected XSS - Vulnerable</li>
        </ol>
    </nav>

    <div class="alert alert-danger">
        <h5><i class="bi bi-exclamation-triangle"></i> HALAMAN VULNERABLE</h5>
        <p class="mb-0">
            Halaman ini SENGAJA dibuat vulnerable untuk demonstrasi. 
            Jangan gunakan pola ini di production!
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-search"></i> Pencarian Tiket (VULNERABLE)
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('xss-lab.reflected.vulnerable') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari tiket..."
                                   value="{{ $searchQuery }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- ============================================ --}}
                    {{-- VULNERABLE CODE! --}}
                    {{-- Menggunakan {!! !!} dengan user input --}}
                    {{-- ============================================ --}}
                    @if($searchQuery)
                        <div class="alert alert-secondary">
                            <strong>Hasil pencarian untuk:</strong>
                            {{-- ❌ VULNERABLE! User input langsung di-render tanpa escape --}}
                            {!! $searchQuery !!}
                        </div>
                    @endif

                    {{-- Contoh hasil pencarian --}}
                    <p class="text-muted">
                        (Tidak ada hasil ditemukan - ini hanya demo)
                    </p>
                </div>
            </div>

            {{-- Penjelasan Kerentanan --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Vulnerable</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>{{-- ❌ VULNERABLE CODE --}}
&lt;div class="alert"&gt;
    Hasil pencarian untuk: {!! $searchQuery !!}
&lt;/div&gt;

{{-- $searchQuery langsung dari user tanpa escaping! --}}
{{-- Jika user memasukkan: &lt;script&gt;alert('XSS')&lt;/script&gt; --}}
{{-- Script akan DIEKSEKUSI! --}}</code></pre>
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
                    <p>Coba masukkan payload berikut di form pencarian:</p>
                    
                    <div class="mb-2">
                        <small class="text-muted">Basic:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Image onerror:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;img src=x onerror=alert('XSS')&gt;</code>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">SVG:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;svg onload=alert('XSS')&gt;</code>
                    </div>
                    
                    <hr>
                    <p class="small text-muted mb-0">
                        Jika muncul alert popup, berarti XSS berhasil!
                    </p>
                </div>
            </div>

            {{-- Link ke versi aman --}}
            <div class="card mt-3 border-success">
                <div class="card-body text-center">
                    <p class="mb-2">Lihat versi yang sudah diperbaiki:</p>
                    <a href="{{ route('xss-lab.reflected.secure') }}" class="btn btn-success">
                        <i class="bi bi-shield-check"></i> Versi Secure
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
