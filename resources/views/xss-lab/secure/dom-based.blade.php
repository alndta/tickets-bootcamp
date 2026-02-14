{{-- ============================================ --}}
{{-- XSS LAB: DOM-Based XSS - SECURE --}}
{{-- ✅ Versi yang sudah diamankan --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'DOM-Based XSS - Secure')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">DOM-Based XSS - Secure</li>
        </ol>
    </nav>

    <div class="alert alert-success">
        <h5><i class="bi bi-shield-check"></i> HALAMAN SECURE</h5>
        <p class="mb-0">
            Halaman ini menggunakan <code>textContent</code> sebagai pengganti <code>innerHTML</code>.
            Script berbahaya akan ditampilkan sebagai teks biasa.
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person"></i> Selamat Datang (SECURE)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Halaman ini membaca nama dari URL hash (#) dan menampilkannya dengan aman.
                    </p>
                    
                    {{-- Area yang secure --}}
                    <div class="p-4 bg-light rounded text-center">
                        <h3>Hello, <span id="username">Guest</span>!</h3>
                    </div>
                    
                    <hr>
                    
                    <p>Coba klik link di bawah:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#Budi" class="btn btn-outline-success" onclick="setTimeout(updateGreeting, 100)">
                            #Budi
                        </a>
                        <a href="#Ani" class="btn btn-outline-success" onclick="setTimeout(updateGreeting, 100)">
                            #Ani
                        </a>
                        <a href="#Admin" class="btn btn-outline-success" onclick="setTimeout(updateGreeting, 100)">
                            #Admin
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kode Secure --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Secure (JavaScript)</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>// ✅ SECURE CODE
function updateGreeting() {
    var hash = window.location.hash.substring(1);
    hash = decodeURIComponent(hash);
    
    if (hash) {
        // ✅ SECURE! textContent tidak parse HTML
        document.getElementById('username').textContent = hash;
    }
}

// Alternatif lain yang aman:
// 1. Gunakan textContent (tidak parse HTML)
// 2. Gunakan createElement() + appendChild()
// 3. Escape manual dengan fungsi custom
// 4. Validasi input dengan whitelist</code></pre>
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
                            <pre class="bg-light p-2 rounded"><code>// innerHTML parse HTML
element.innerHTML = userInput;

// Jika userInput = "&lt;script&gt;..."
// Script akan dieksekusi!</code></pre>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Secure:</h6>
                            <pre class="bg-light p-2 rounded"><code>// textContent tidak parse HTML
element.textContent = userInput;

// Jika userInput = "&lt;script&gt;..."
// Ditampilkan sebagai teks</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Escape Function --}}
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="bi bi-code"></i> Custom Escape Function</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>// Jika HARUS menggunakan innerHTML, escape dulu:
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Penggunaan:
element.innerHTML = 'Hello, ' + escapeHtml(userInput) + '!';

// Atau validasi dengan whitelist:
function isValidName(name) {
    return /^[a-zA-Z0-9 ]+$/.test(name);
}

if (isValidName(hash)) {
    element.textContent = hash;
}</code></pre>
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
                    <p>Coba payload yang sama:</p>
                    
                    <div class="mb-3">
                        <a href="#<img src=x onerror=alert('XSS')>" 
                           class="btn btn-outline-success btn-sm d-block"
                           onclick="setTimeout(updateGreeting, 100)">
                            Test: img onerror
                        </a>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-success small mb-0">
                        <i class="bi bi-check-circle"></i>
                        <strong>Aman!</strong> Payload akan ditampilkan 
                        sebagai TEKS biasa.
                    </div>
                </div>
            </div>

            {{-- Link ke versi vulnerable --}}
            <div class="card mt-3 border-danger">
                <div class="card-body text-center">
                    <p class="mb-2">Bandingkan dengan versi vulnerable:</p>
                    <a href="{{ route('xss-lab.dom.vulnerable') }}" class="btn btn-outline-danger">
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
                        <li>Gunakan <code>textContent</code> bukan <code>innerHTML</code></li>
                        <li>Gunakan <code>setAttribute()</code> dengan hati-hati</li>
                        <li>Hindari <code>eval()</code>, <code>setTimeout(string)</code></li>
                        <li>Validasi input dengan whitelist</li>
                        <li>Gunakan library sanitizer (DOMPurify)</li>
                    </ul>
                </div>
            </div>

            {{-- DOMPurify Info --}}
            <div class="card mt-3 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-shield"></i> DOMPurify</h6>
                </div>
                <div class="card-body small">
                    <p>Untuk kasus yang perlu render HTML:</p>
                    <pre class="bg-light p-2 rounded"><code>// Install: npm install dompurify

import DOMPurify from 'dompurify';

// Sanitize sebelum innerHTML
element.innerHTML = 
    DOMPurify.sanitize(userInput);</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ✅ SECURE CODE
    function updateGreeting() {
        var hash = window.location.hash.substring(1);
        
        // Decode untuk menangani URL encoding
        hash = decodeURIComponent(hash);
        
        if (hash) {
            // ✅ SECURE! textContent tidak parse HTML
            document.getElementById('username').textContent = hash;
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
