{{-- ============================================ --}}
{{-- Security Testing Dashboard - Index --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Security Testing Dashboard')

@section('content')
<div class="container py-4">
    <div class="text-center mb-5">
        <h1 class="display-5">
            <i class="bi bi-shield-shaded text-primary"></i> Security Testing Dashboard
        </h1>
        <p class="lead text-muted">
            Materi Hari 5 - Lab Lengkap XSS Prevention
        </p>
        <div class="alert alert-warning d-inline-block">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>HANYA UNTUK DEVELOPMENT!</strong> 
            Jangan deploy dashboard ini ke production.
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-center h-100 border-success">
                <div class="card-body">
                    <i class="bi bi-shield-check text-success display-4"></i>
                    <h3 class="mt-2">XSS</h3>
                    <p class="text-muted mb-0">Protection</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-primary">
                <div class="card-body">
                    <i class="bi bi-key text-primary display-4"></i>
                    <h3 class="mt-2">CSRF</h3>
                    <p class="text-muted mb-0">Token Active</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-info">
                <div class="card-body">
                    <i class="bi bi-server text-info display-4"></i>
                    <h3 class="mt-2">Headers</h3>
                    <p class="text-muted mb-0">Configured</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100 border-warning">
                <div class="card-body">
                    <i class="bi bi-check2-square text-warning display-4"></i>
                    <h3 class="mt-2">Audit</h3>
                    <p class="text-muted mb-0">Checklist</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Testing Sections --}}
    <div class="row g-4">
        {{-- XSS Testing --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-exclamation"></i> XSS Testing
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Test berbagai payload XSS untuk memverifikasi 
                        bahwa aplikasi aman dari serangan Cross-Site Scripting.
                    </p>
                    <ul class="small">
                        <li>Reflected XSS Test</li>
                        <li>Stored XSS Test</li>
                        <li>DOM-Based XSS Test</li>
                        <li>Multiple Payload Types</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('security-testing.xss') }}" class="btn btn-danger w-100">
                        <i class="bi bi-play-circle"></i> Mulai XSS Test
                    </a>
                </div>
            </div>
        </div>

        {{-- CSRF Testing --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-key"></i> CSRF Testing
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Test CSRF protection untuk memastikan form 
                        tidak bisa disubmit dari external source.
                    </p>
                    <ul class="small">
                        <li>Test form dengan CSRF token</li>
                        <li>Test form tanpa CSRF token</li>
                        <li>External form attack simulation</li>
                        <li>AJAX request testing</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('security-testing.csrf') }}" class="btn btn-primary w-100">
                        <i class="bi bi-play-circle"></i> Mulai CSRF Test
                    </a>
                </div>
            </div>
        </div>

        {{-- Security Headers --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-server"></i> Security Headers
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Verifikasi security headers yang dikirim 
                        oleh server untuk perlindungan tambahan.
                    </p>
                    <ul class="small">
                        <li>Content-Security-Policy</li>
                        <li>X-Frame-Options</li>
                        <li>X-Content-Type-Options</li>
                        <li>X-XSS-Protection</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('security-testing.headers') }}" class="btn btn-info w-100">
                        <i class="bi bi-play-circle"></i> Cek Headers
                    </a>
                </div>
            </div>
        </div>

        {{-- Audit Checklist --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check"></i> Security Audit
                    </h5>
                </div>
                <div class="card-body">
                    <p>
                        Checklist lengkap untuk audit keamanan aplikasi 
                        sebelum deployment ke production.
                    </p>
                    <ul class="small">
                        <li>XSS Prevention Checklist</li>
                        <li>CSRF Protection Checklist</li>
                        <li>Input Validation Checklist</li>
                        <li>Authentication & Authorization</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('security-testing.audit') }}" class="btn btn-warning w-100">
                        <i class="bi bi-play-circle"></i> Lihat Checklist
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="card mt-5">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-link-45deg"></i> Quick Links
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('xss-lab.index') }}" class="btn btn-outline-danger w-100">
                        <i class="bi bi-shield-exclamation"></i> XSS Lab (Hari 4)
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('demo-blade.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-file-code"></i> Blade Demo (Hari 4)
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-ticket-perforated"></i> Tickets (Hari 3)
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Terminal Commands --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-terminal"></i> Useful Commands
            </h5>
        </div>
        <div class="card-body bg-dark text-white">
            <p class="text-muted mb-2"># Check security headers via curl:</p>
            <pre class="mb-3"><code>curl -I http://localhost:8000</code></pre>
            
            <p class="text-muted mb-2"># Run Laravel security checker:</p>
            <pre class="mb-3"><code>composer require enlightn/security-checker --dev
php artisan security:check</code></pre>
            
            <p class="text-muted mb-2"># npm audit for JS dependencies:</p>
            <pre class="mb-0"><code>npm audit
npm audit fix</code></pre>
        </div>
    </div>
</div>
@endsection
