{{-- ============================================ --}}
{{-- Security Testing - Headers Test --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Security Headers - Security Dashboard')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>
                <i class="bi bi-server text-info"></i> Security Headers
            </h2>
            <p class="text-muted mb-0">
                Verifikasi security headers yang dikirim oleh server
            </p>
        </div>
        <a href="{{ route('security-testing.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Expected Headers --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-check"></i> Expected Security Headers
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Header</th>
                            <th>Value</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expectedHeaders as $header => $value)
                            <tr>
                                <td><code>{{ $header }}</code></td>
                                <td>
                                    <small class="text-break">
                                        {{ Str::limit($value, 60) }}
                                    </small>
                                </td>
                                <td class="small">
                                    @switch($header)
                                        @case('X-Content-Type-Options')
                                            Mencegah browser melakukan MIME type sniffing
                                            @break
                                        @case('X-Frame-Options')
                                            Mencegah clickjacking (iframe embedding)
                                            @break
                                        @case('X-XSS-Protection')
                                            Aktifkan XSS filter bawaan browser
                                            @break
                                        @case('Referrer-Policy')
                                            Kontrol informasi referrer yang dikirim
                                            @break
                                        @case('Content-Security-Policy')
                                            Kontrol sumber daya yang boleh dimuat
                                            @break
                                        @default
                                            -
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Live Check --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-broadcast"></i> Live Header Check
            </h5>
        </div>
        <div class="card-body">
            <p class="small text-muted">
                Klik tombol di bawah untuk mengecek headers yang dikirim server:
            </p>
            
            <button class="btn btn-primary mb-3" onclick="checkHeaders()">
                <i class="bi bi-arrow-repeat"></i> Check Headers
            </button>
            
            <div id="headersResult" style="display: none;">
                <h6>Response Headers:</h6>
                <div class="bg-dark text-white p-3 rounded">
                    <pre id="headersOutput" class="mb-0 text-white"></pre>
                </div>
            </div>
        </div>
    </div>

    {{-- How to Check Manually --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-terminal"></i> Via Terminal (curl)
                    </h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code># Check headers
curl -I {{ url('/') }}

# Dengan verbose output
curl -v {{ url('/') }} 2>&1 | grep -i "^< "</code></pre>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-browser-chrome"></i> Via Browser DevTools
                    </h6>
                </div>
                <div class="card-body">
                    <ol class="small mb-0">
                        <li>Buka Chrome/Firefox DevTools (F12)</li>
                        <li>Pergi ke tab <strong>Network</strong></li>
                        <li>Refresh halaman</li>
                        <li>Klik request pertama (document)</li>
                        <li>Lihat <strong>Response Headers</strong></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- CSP Explanation --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-shield-lock"></i> Content-Security-Policy Details
            </h5>
        </div>
        <div class="card-body">
            <p class="small text-muted">
                CSP adalah header paling penting untuk mencegah XSS. 
                Berikut penjelasan directive yang digunakan:
            </p>
            
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Directive</th>
                            <th>Value</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>default-src</code></td>
                            <td>'self'</td>
                            <td>Fallback: hanya dari domain sendiri</td>
                        </tr>
                        <tr>
                            <td><code>script-src</code></td>
                            <td>'self' 'unsafe-inline' cdn...</td>
                            <td>JavaScript dari domain sendiri, inline, dan CDN</td>
                        </tr>
                        <tr>
                            <td><code>style-src</code></td>
                            <td>'self' 'unsafe-inline' cdn...</td>
                            <td>CSS dari domain sendiri, inline, dan CDN</td>
                        </tr>
                        <tr>
                            <td><code>img-src</code></td>
                            <td>'self' data: https:</td>
                            <td>Gambar dari sendiri, data URI, dan HTTPS</td>
                        </tr>
                        <tr>
                            <td><code>frame-ancestors</code></td>
                            <td>'self'</td>
                            <td>Hanya bisa di-iframe oleh domain sendiri</td>
                        </tr>
                        <tr>
                            <td><code>form-action</code></td>
                            <td>'self'</td>
                            <td>Form hanya bisa submit ke domain sendiri</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-warning small mt-3 mb-0">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Note:</strong> 
                <code>'unsafe-inline'</code> dan <code>'unsafe-eval'</code> mengurangi 
                efektivitas CSP. Idealnya gunakan nonce atau hash untuk inline scripts.
            </div>
        </div>
    </div>

    {{-- Online Tools --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-tools"></i> Online Security Header Tools
            </h5>
        </div>
        <div class="card-body">
            <p class="small text-muted">
                Gunakan tools berikut untuk analisis lebih mendalam (setelah deploy):
            </p>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="https://securityheaders.com" 
                       target="_blank" 
                       class="btn btn-outline-primary w-100">
                        <i class="bi bi-box-arrow-up-right"></i> SecurityHeaders.com
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="https://observatory.mozilla.org" 
                       target="_blank" 
                       class="btn btn-outline-primary w-100">
                        <i class="bi bi-box-arrow-up-right"></i> Mozilla Observatory
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="https://csp-evaluator.withgoogle.com" 
                       target="_blank" 
                       class="btn btn-outline-primary w-100">
                        <i class="bi bi-box-arrow-up-right"></i> CSP Evaluator
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Middleware Code --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-code-slash"></i> SecurityHeaders Middleware
            </h5>
        </div>
        <div class="card-body">
            <p class="small text-muted">
                File: <code>app/Http/Middleware/SecurityHeaders.php</code>
            </p>
            <pre class="bg-light p-3 rounded small"><code>public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    // Prevent MIME sniffing
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    
    // Prevent clickjacking
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    
    // XSS filter (legacy browsers)
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    
    // Referrer policy
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    
    // Content Security Policy
    $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' ...";
    $response->headers->set('Content-Security-Policy', $csp);

    return $response;
}</code></pre>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function checkHeaders() {
        const resultDiv = document.getElementById('headersResult');
        const output = document.getElementById('headersOutput');
        
        resultDiv.style.display = 'block';
        output.textContent = 'Loading...';
        
        fetch('{{ url("/") }}', { method: 'HEAD' })
            .then(response => {
                let headers = '';
                response.headers.forEach((value, key) => {
                    // Only show security-related headers
                    const securityHeaders = [
                        'x-content-type-options',
                        'x-frame-options',
                        'x-xss-protection',
                        'content-security-policy',
                        'referrer-policy',
                        'permissions-policy',
                        'strict-transport-security'
                    ];
                    
                    if (securityHeaders.includes(key.toLowerCase())) {
                        headers += `${key}: ${value}\n`;
                    }
                });
                
                if (!headers) {
                    headers = 'No security headers found!\n';
                    headers += '(Make sure SecurityHeaders middleware is registered)';
                }
                
                output.textContent = headers;
            })
            .catch(error => {
                output.textContent = 'Error: ' + error.message;
            });
    }
</script>
@endpush
@endsection
