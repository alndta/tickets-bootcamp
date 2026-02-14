{{-- ============================================ --}}
{{-- Security Testing - XSS Test --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'XSS Testing - Security Dashboard')

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>
                <i class="bi bi-shield-exclamation text-danger"></i> XSS Testing
            </h2>
            <p class="text-muted mb-0">
                Test XSS payloads untuk memverifikasi keamanan aplikasi
            </p>
        </div>
        <a href="{{ route('security-testing.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        {{-- Reflected XSS Test --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-repeat"></i> Reflected XSS Test
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Test bagaimana aplikasi menangani input dari URL parameter.
                    </p>
                    
                    <form method="GET" action="{{ route('security-testing.xss') }}">
                        <div class="mb-3">
                            <label for="testInput" class="form-label">Test Input</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="testInput"
                                   name="test" 
                                   value="{{ $testInput }}"
                                   placeholder="Masukkan payload XSS...">
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-play"></i> Test
                        </button>
                    </form>

                    @if($testInput)
                        <div class="mt-4">
                            <h6>Result:</h6>
                            
                            {{-- Secure Output --}}
                            <div class="alert alert-success">
                                <strong>✅ Secure (auto-escaped):</strong><br>
                                <code>@{{ $testInput }}</code>
                                <hr>
                                Output: {{ $testInput }}
                            </div>
                            
                            {{-- Vulnerable Output (untuk demonstrasi) --}}
                            <div class="alert alert-danger">
                                <strong>❌ Vulnerable (raw output):</strong><br>
                                <code>@{!! $testInput !!}</code>
                                <hr>
                                <div class="border p-2 bg-white">
                                    {{-- WARNING: Ini vulnerable! Hanya untuk demo --}}
                                    <small class="text-muted">[Preview disabled for safety]</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Payloads Reference --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-terminal"></i> XSS Payloads
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Klik untuk copy payload ke clipboard:
                    </p>

                    <h6>Basic Payloads:</h6>
                    @php
                        $payloads = [
                            '<script>alert("XSS")</script>',
                            '<img src=x onerror=alert("XSS")>',
                            '<svg onload=alert("XSS")>',
                            '<body onload=alert("XSS")>',
                            '<iframe src="javascript:alert(\'XSS\')">',
                        ];
                    @endphp
                    
                    @foreach($payloads as $index => $payload)
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" 
                                   class="form-control font-monospace" 
                                   value="{{ $payload }}" 
                                   id="payload{{ $index }}"
                                   readonly>
                            <button class="btn btn-outline-secondary" 
                                    type="button"
                                    onclick="copyPayload('payload{{ $index }}')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    @endforeach

                    <h6 class="mt-4">Event Handler Payloads:</h6>
                    @php
                        $eventPayloads = [
                            '<input onfocus=alert("XSS") autofocus>',
                            '<marquee onstart=alert("XSS")>',
                            '<details open ontoggle=alert("XSS")>',
                            '<a href="javascript:alert(\'XSS\')">Click</a>',
                        ];
                    @endphp
                    
                    @foreach($eventPayloads as $index => $payload)
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" 
                                   class="form-control font-monospace" 
                                   value="{{ $payload }}" 
                                   id="eventPayload{{ $index }}"
                                   readonly>
                            <button class="btn btn-outline-secondary" 
                                    type="button"
                                    onclick="copyPayload('eventPayload{{ $index }}')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    @endforeach

                    <h6 class="mt-4">Encoded Payloads:</h6>
                    @php
                        $encodedPayloads = [
                            '&#60;script&#62;alert("XSS")&#60;/script&#62;',
                            '%3Cscript%3Ealert("XSS")%3C/script%3E',
                            '\\x3cscript\\x3ealert("XSS")\\x3c/script\\x3e',
                        ];
                    @endphp
                    
                    @foreach($encodedPayloads as $index => $payload)
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" 
                                   class="form-control font-monospace" 
                                   value="{{ $payload }}" 
                                   id="encodedPayload{{ $index }}"
                                   readonly>
                            <button class="btn btn-outline-secondary" 
                                    type="button"
                                    onclick="copyPayload('encodedPayload{{ $index }}')">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Test Result Summary --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-clipboard-check"></i> XSS Test Checklist
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Test</th>
                            <th>Payload</th>
                            <th>Expected Result</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Script Tag</td>
                            <td><code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></td>
                            <td>Ditampilkan sebagai teks</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                        </tr>
                        <tr>
                            <td>Event Handler</td>
                            <td><code>&lt;img src=x onerror=alert('XSS')&gt;</code></td>
                            <td>Tidak ada alert</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                        </tr>
                        <tr>
                            <td>SVG Payload</td>
                            <td><code>&lt;svg onload=alert('XSS')&gt;</code></td>
                            <td>Tidak ada alert</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                        </tr>
                        <tr>
                            <td>JavaScript URL</td>
                            <td><code>&lt;a href="javascript:..."&gt;</code></td>
                            <td>Link tidak berfungsi</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                        </tr>
                        <tr>
                            <td>Encoded Payload</td>
                            <td><code>&amp;#60;script&amp;#62;...</code></td>
                            <td>Ditampilkan sebagai teks</td>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="mt-4">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('xss-lab.reflected.secure') }}?q={{ urlencode('<script>alert(1)</script>') }}" 
               class="btn btn-success" target="_blank">
                <i class="bi bi-lock"></i> Test Secure Page
            </a>
            <a href="{{ route('xss-lab.reflected.vulnerable') }}?q={{ urlencode('<script>alert(1)</script>') }}" 
               class="btn btn-danger" target="_blank">
                <i class="bi bi-unlock"></i> Test Vulnerable Page
            </a>
            <a href="{{ route('xss-lab.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-shield-exclamation"></i> XSS Lab
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyPayload(elementId) {
        const input = document.getElementById(elementId);
        input.select();
        navigator.clipboard.writeText(input.value);
        
        // Visual feedback
        const btn = input.nextElementSibling;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check"></i>';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 1500);
    }
</script>
@endpush
@endsection
