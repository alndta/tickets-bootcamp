{{-- ============================================ --}}
{{-- XSS LAB: Index --}}
{{-- Menu utama untuk Lab XSS --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'XSS Lab - Secure Coding')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-5">
            <i class="bi bi-shield-exclamation text-danger"></i> XSS Lab
        </h1>
        <p class="lead text-muted">
            Materi Hari 4 - Bagian 2, 3, dan 4: Cross-Site Scripting
        </p>
        <div class="alert alert-danger d-inline-block">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>PERINGATAN:</strong> Lab ini HANYA untuk pembelajaran. 
            Jangan gunakan teknik ini untuk menyerang website lain!
        </div>
    </div>

    {{-- Reset Comments Button --}}
    <div class="text-end mb-4">
        <form action="{{ route('xss-lab.reset-comments') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary btn-sm" 
                    onclick="return confirm('Reset semua komentar?')">
                <i class="bi bi-arrow-clockwise"></i> Reset Comments
            </button>
        </form>
    </div>

    <div class="row g-4">
        {{-- ============================================ --}}
        {{-- REFLECTED XSS --}}
        {{-- ============================================ --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-repeat"></i> Reflected XSS
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Payload dikirim via URL/request dan langsung di-reflect 
                        ke response tanpa disimpan.
                    </p>
                    <ul class="small">
                        <li>Payload ada di URL</li>
                        <li>Tidak disimpan di database</li>
                        <li>Korban harus klik link berbahaya</li>
                    </ul>
                    <p class="small text-muted">
                        <strong>Contoh:</strong> Search query, error messages
                    </p>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('xss-lab.reflected.vulnerable') }}" 
                           class="btn btn-danger flex-fill">
                            <i class="bi bi-unlock"></i> Vulnerable
                        </a>
                        <a href="{{ route('xss-lab.reflected.secure') }}" 
                           class="btn btn-success flex-fill">
                            <i class="bi bi-lock"></i> Secure
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- STORED XSS --}}
        {{-- ============================================ --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-database"></i> Stored XSS
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Payload disimpan di database dan dieksekusi setiap kali 
                        halaman dikunjungi.
                    </p>
                    <ul class="small">
                        <li>Payload tersimpan di database</li>
                        <li>Menyerang SEMUA pengunjung</li>
                        <li>Lebih berbahaya!</li>
                    </ul>
                    <p class="small text-muted">
                        <strong>Contoh:</strong> Komentar, profil, forum post
                    </p>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('xss-lab.stored.vulnerable') }}" 
                           class="btn btn-danger flex-fill">
                            <i class="bi bi-unlock"></i> Vulnerable
                        </a>
                        <a href="{{ route('xss-lab.stored.secure') }}" 
                           class="btn btn-success flex-fill">
                            <i class="bi bi-lock"></i> Secure
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- DOM-BASED XSS --}}
        {{-- ============================================ --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-code-slash"></i> DOM-Based XSS
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Eksploitasi terjadi di client-side. Payload tidak pernah 
                        dikirim ke server.
                    </p>
                    <ul class="small">
                        <li>Manipulasi DOM via JavaScript</li>
                        <li>Server tidak melihat payload</li>
                        <li>Sulit dideteksi di server log</li>
                    </ul>
                    <p class="small text-muted">
                        <strong>Contoh:</strong> URL fragment, client-side routing
                    </p>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-2">
                        <a href="{{ route('xss-lab.dom.vulnerable') }}" 
                           class="btn btn-danger flex-fill">
                            <i class="bi bi-unlock"></i> Vulnerable
                        </a>
                        <a href="{{ route('xss-lab.dom.secure') }}" 
                           class="btn btn-success flex-fill">
                            <i class="bi bi-lock"></i> Secure
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- XSS PAYLOADS UNTUK TESTING --}}
    {{-- ============================================ --}}
    <div class="card mt-5">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-terminal"></i> Payload untuk Testing
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted">Copy payload di bawah untuk testing di halaman vulnerable:</p>
            
            <div class="row">
                <div class="col-md-6">
                    <h6>Basic Payloads:</h6>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload1">&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload1')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload2">&lt;img src=x onerror=alert('XSS')&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload2')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload3">&lt;svg onload=alert('XSS')&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload3')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Advanced Payloads:</h6>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload4">&lt;body onload=alert('XSS')&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload4')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload5">&lt;input onfocus=alert('XSS') autofocus&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload5')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bg-light p-2 rounded mb-2">
                        <code id="payload6">&lt;marquee onstart=alert('XSS')&gt;</code>
                        <button class="btn btn-sm btn-outline-secondary float-end" 
                                onclick="copyPayload('payload6')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- PERBANDINGAN BLADE ESCAPE --}}
    {{-- ============================================ --}}
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">
                <i class="bi bi-braces"></i> Perbandingan @{{ }} vs @{!! !!}
            </h5>
        </div>
        <div class="card-body">
            @php
                $maliciousInput = '<script>alert("XSS")</script>';
                $safeHtml = '<strong>Teks tebal</strong>';
            @endphp
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            ✅ AMAN: @{{ $input }}
                        </div>
                        <div class="card-body">
                            <p><strong>Input:</strong></p>
                            <pre class="bg-light p-2">{{ $maliciousInput }}</pre>
                            
                            <p><strong>Output:</strong></p>
                            <div class="bg-light p-3 border rounded">
                                {{ $maliciousInput }}
                            </div>
                            <small class="text-success">
                                Script ditampilkan sebagai TEKS, tidak dieksekusi!
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            ❌ BERBAHAYA: {!! $input !!}
                        </div>
                        <div class="card-body">
                            <p><strong>Input:</strong></p>
                            <pre class="bg-light p-2">{{ $maliciousInput }}</pre>
                            
                            <p><strong>Output:</strong></p>
                            <div class="bg-light p-3 border rounded">
                                {{-- JANGAN LAKUKAN INI dengan user input! --}}
                                <span class="text-danger">[Script akan dieksekusi!]</span>
                            </div>
                            <small class="text-danger">
                                Script akan DIEKSEKUSI oleh browser!
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Back to Demo Blade --}}
    <div class="mt-5 text-center">
        <hr>
        <a href="{{ route('demo-blade.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Demo Blade
        </a>
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-ticket"></i> Kembali ke Tickets
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyPayload(elementId) {
    const element = document.getElementById(elementId);
    const text = element.textContent;
    
    // Decode HTML entities for copying
    const textarea = document.createElement('textarea');
    textarea.innerHTML = text;
    const decoded = textarea.value;
    
    navigator.clipboard.writeText(decoded).then(() => {
        alert('Payload copied!');
    });
}
</script>
@endpush
