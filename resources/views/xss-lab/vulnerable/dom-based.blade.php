{{-- ============================================ --}}
{{-- XSS LAB: DOM-Based XSS - VULNERABLE --}}
{{-- ⚠️ JANGAN GUNAKAN DI PRODUCTION! --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'DOM-Based XSS - Vulnerable')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">DOM-Based XSS - Vulnerable</li>
        </ol>
    </nav>

    <div class="alert alert-danger">
        <h5><i class="bi bi-exclamation-triangle"></i> HALAMAN VULNERABLE</h5>
        <p class="mb-0">
            Halaman ini menggunakan <code>innerHTML</code> untuk menampilkan data dari URL hash.
            Payload tidak pernah dikirim ke server, eksploitasi terjadi murni di client-side!
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person"></i> Selamat Datang (VULNERABLE)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Halaman ini membaca nama dari URL hash (#) dan menampilkannya.
                    </p>
                    
                    {{-- Area yang vulnerable --}}
                    <div class="p-4 bg-light rounded text-center">
                        <h3 id="greeting">Hello, Guest!</h3>
                    </div>
                    
                    <hr>
                    
                    <p>Coba klik link di bawah:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#Budi" class="btn btn-outline-primary" onclick="updateGreeting()">
                            #Budi
                        </a>
                        <a href="#Ani" class="btn btn-outline-primary" onclick="updateGreeting()">
                            #Ani
                        </a>
                        <a href="#Admin" class="btn btn-outline-primary" onclick="updateGreeting()">
                            #Admin
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kode Vulnerable --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Vulnerable (JavaScript)</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>// ❌ VULNERABLE CODE
function updateGreeting() {
    // Ambil hash dari URL (setelah #)
    var hash = window.location.hash.substring(1);
    
    if (hash) {
        // VULNERABLE! innerHTML dengan user input
        document.getElementById('greeting').innerHTML = 
            'Hello, ' + hash + '!';
    }
}

// Jalankan saat hash berubah
window.addEventListener('hashchange', updateGreeting);

// Payload attack:
// URL: /page#&lt;img src=x onerror=alert('XSS')&gt;
// Script akan dieksekusi!</code></pre>
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
                    <p>Klik link berbahaya di bawah:</p>
                    
                    <div class="mb-3">
                        <a href="#<img src=x onerror=alert('DOM XSS!')>" 
                           class="btn btn-danger btn-sm d-block"
                           onclick="setTimeout(updateGreeting, 100)">
                            <i class="bi bi-bug"></i> Test: img onerror
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <a href="#<svg onload=alert('SVG XSS')>" 
                           class="btn btn-danger btn-sm d-block"
                           onclick="setTimeout(updateGreeting, 100)">
                            <i class="bi bi-bug"></i> Test: svg onload
                        </a>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle"></i>
                        <strong>Catatan:</strong> Payload ada di URL (setelah #), 
                        tidak dikirim ke server!
                    </div>
                </div>
            </div>

            {{-- Link ke versi aman --}}
            <div class="card mt-3 border-success">
                <div class="card-body text-center">
                    <p class="mb-2">Lihat versi yang sudah diperbaiki:</p>
                    <a href="{{ route('xss-lab.dom.secure') }}" class="btn btn-success">
                        <i class="bi bi-shield-check"></i> Versi Secure
                    </a>
                </div>
            </div>

            {{-- Perbedaan DOM XSS --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-question-circle"></i> Kenapa Berbeda?</h6>
                </div>
                <div class="card-body small">
                    <p>DOM-Based XSS berbeda karena:</p>
                    <ul class="mb-0">
                        <li>Payload tidak dikirim ke server</li>
                        <li>Tidak ada di server log</li>
                        <li>WAF tidak bisa mendeteksi</li>
                        <li>Murni client-side vulnerability</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ❌ VULNERABLE CODE
    function updateGreeting() {
        // Ambil hash dari URL (setelah #)
        var hash = window.location.hash.substring(1);
        
        // Decode untuk menangani URL encoding
        hash = decodeURIComponent(hash);
        
        if (hash) {
            // VULNERABLE! innerHTML dengan user input
            document.getElementById('greeting').innerHTML = 
                'Hello, ' + hash + '!';
        }
    }
    
    // Jalankan saat hash berubah
    window.addEventListener('hashchange', updateGreeting);
    
    // Jalankan saat page load jika ada hash
    if (window.location.hash) {
        updateGreeting();
    }
</script>
@endpush
