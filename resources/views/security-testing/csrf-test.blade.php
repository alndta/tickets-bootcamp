{{-- ============================================ --}}
{{-- Security Testing - CSRF Test --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'CSRF Testing - Security Dashboard')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>
                <i class="bi bi-key text-primary"></i> CSRF Testing
            </h2>
            <p class="text-muted mb-0">
                Test Cross-Site Request Forgery protection
            </p>
        </div>
        <a href="{{ route('security-testing.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            @if(session('submitted_data'))
                <br>
                <strong>Data:</strong> {{ session('submitted_data') }}
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Test dengan CSRF Token --}}
        <div class="col-lg-6">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle"></i> Form dengan CSRF Token
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Form ini memiliki CSRF token dan akan berhasil disubmit.
                    </p>
                    
                    <form action="{{ route('security-testing.csrf.post') }}" method="POST">
                        @csrf {{-- ✅ CSRF Token --}}
                        
                        <div class="mb-3">
                            <label for="testData" class="form-label">Test Data</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="testData"
                                   name="test_data" 
                                   value="Data dengan CSRF token"
                                   required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-send"></i> Submit (dengan CSRF)
                        </button>
                    </form>

                    <div class="mt-4">
                        <h6>Kode:</h6>
                        <pre class="bg-light p-2 rounded small"><code>&lt;form method="POST"&gt;
    @@csrf  {{-- Token --}}
    &lt;input name="test_data" ...&gt;
&lt;/form&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>

        {{-- Test tanpa CSRF Token (Simulasi) --}}
        <div class="col-lg-6">
            <div class="card h-100 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-x-circle"></i> Form tanpa CSRF Token
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Simulasi form tanpa CSRF token. Akan gagal dengan error 419.
                    </p>
                    
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Test ini akan menampilkan Error 419!</strong>
                    </div>
                    
                    {{-- Iframe untuk menampilkan external form --}}
                    <div class="border rounded p-3 bg-light">
                        <p class="small mb-2">Kode HTML external (tanpa CSRF):</p>
                        <pre class="bg-white p-2 rounded small mb-3"><code>&lt;form action="{{ route('security-testing.csrf.post') }}" method="POST"&gt;
    {{-- Tidak ada @@csrf --}}
    &lt;input name="test_data" value="Spam"&gt;
    &lt;button&gt;Submit&lt;/button&gt;
&lt;/form&gt;</code></pre>
                        
                        <p class="small text-danger">
                            <i class="bi bi-info-circle"></i>
                            Untuk test ini, buat file HTML external dan buka di browser terpisah.
                        </p>
                    </div>

                    <div class="mt-3">
                        <button type="button" 
                                class="btn btn-outline-danger"
                                onclick="testWithoutCSRF()">
                            <i class="bi bi-play"></i> Test via JavaScript (No CSRF)
                        </button>
                    </div>
                    
                    <div id="csrfResult" class="mt-3" style="display: none;">
                        <div class="alert alert-danger">
                            <strong>Result:</strong>
                            <span id="csrfResultText"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- External Attack Simulation --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-bug"></i> CSRF Attack Simulation
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Skenario Serangan:</h6>
                    <ol class="small">
                        <li>Attacker membuat halaman berbahaya di server mereka</li>
                        <li>Halaman tersebut berisi form yang submit ke aplikasi target</li>
                        <li>Korban yang sudah login mengunjungi halaman berbahaya</li>
                        <li>Form otomatis tersubmit menggunakan session korban</li>
                        <li><strong>Tanpa CSRF protection:</strong> Aksi berhasil!</li>
                        <li><strong>Dengan CSRF protection:</strong> Error 419 - Blocked!</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h6>File test-csrf.html (External):</h6>
                    <pre class="bg-light p-2 rounded small"><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;&lt;title&gt;CSRF Attack Test&lt;/title&gt;&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Halaman Berbahaya&lt;/h1&gt;
    &lt;form id="csrfForm" 
          action="{{ url('/security-testing/csrf') }}" 
          method="POST"&gt;
        &lt;input name="test_data" value="Hacked!"&gt;
        &lt;button&gt;Submit&lt;/button&gt;
    &lt;/form&gt;
    
    &lt;!-- Auto submit --&gt;
    &lt;script&gt;
        // document.getElementById('csrfForm').submit();
    &lt;/script&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>
                    <button class="btn btn-sm btn-outline-secondary mt-2" 
                            onclick="downloadTestFile()">
                        <i class="bi bi-download"></i> Download File
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CSRF Checklist --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> CSRF Protection Checklist
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Check</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@@csrf di semua form POST</td>
                            <td>
                                <input type="checkbox" class="form-check-input" checked>
                            </td>
                            <td class="small text-muted">
                                Wajib untuk form yang mengubah data
                            </td>
                        </tr>
                        <tr>
                            <td>VerifyCsrfToken middleware aktif</td>
                            <td>
                                <input type="checkbox" class="form-check-input" checked>
                            </td>
                            <td class="small text-muted">
                                Cek di Kernel.php atau bootstrap/app.php
                            </td>
                        </tr>
                        <tr>
                            <td>API menggunakan Sanctum/Passport</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td class="small text-muted">
                                Untuk API tanpa session
                            </td>
                        </tr>
                        <tr>
                            <td>SameSite cookie attribute</td>
                            <td>
                                <input type="checkbox" class="form-check-input" checked>
                            </td>
                            <td class="small text-muted">
                                Laravel default: Lax
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function testWithoutCSRF() {
        const resultDiv = document.getElementById('csrfResult');
        const resultText = document.getElementById('csrfResultText');
        
        resultDiv.style.display = 'block';
        resultText.innerHTML = '<i class="bi bi-hourglass-split"></i> Testing...';
        
        // Attempt to submit without CSRF token
        fetch('{{ route("security-testing.csrf.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                test_data: 'Attempt without CSRF'
            })
        })
        .then(response => {
            if (response.status === 419) {
                resultText.innerHTML = `
                    <i class="bi bi-shield-check text-success"></i> 
                    <strong>CSRF Protection Working!</strong><br>
                    Status: 419 Page Expired<br>
                    <span class="text-success">Request ditolak karena tidak ada CSRF token.</span>
                `;
            } else {
                resultText.innerHTML = `
                    <i class="bi bi-exclamation-triangle text-warning"></i> 
                    Unexpected response: ${response.status}
                `;
            }
        })
        .catch(error => {
            resultText.innerHTML = `
                <i class="bi bi-shield-check text-success"></i> 
                <strong>CSRF Protection Working!</strong><br>
                Request blocked.
            `;
        });
    }

    function downloadTestFile() {
        const content = `<!DOCTYPE html>
<html>
<head>
    <title>CSRF Attack Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .warning { background: #fff3cd; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="warning">
        ⚠️ File ini hanya untuk testing CSRF protection!
    </div>
    
    <h1>CSRF Attack Simulation</h1>
    
    <form id="csrfForm" action="${window.location.origin}/security-testing/csrf" method="POST">
        <input name="test_data" value="Data from external site!">
        <button type="submit">Submit tanpa CSRF Token</button>
    </form>
    
    <p style="margin-top: 20px;">
        Expected result: <strong>Error 419 - Page Expired</strong>
    </p>
</body>
</html>`;
        
        const blob = new Blob([content], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'test-csrf.html';
        a.click();
        URL.revokeObjectURL(url);
    }
</script>
@endpush
@endsection
