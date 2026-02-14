{{-- ============================================ --}}
{{-- DEMO BLADE: Stacks & Push --}}
{{-- Menambahkan CSS/JS per halaman --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Demo: Stacks & Push')

{{-- ============================================ --}}
{{-- @push untuk menambahkan styles --}}
{{-- ============================================ --}}
@push('styles')
<style>
    /* CSS khusus untuk halaman ini */
    .demo-box {
        padding: 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .demo-box:hover {
        transform: scale(1.02);
    }
    
    .gradient-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .animated-border {
        border: 3px solid transparent;
        background: linear-gradient(white, white) padding-box,
                    linear-gradient(45deg, #f093fb, #f5576c) border-box;
    }
    
    .custom-highlight {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 15px;
    }
</style>
@endpush

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('demo-blade.index') }}">Demo Blade</a></li>
            <li class="breadcrumb-item active">Stacks & Push</li>
        </ol>
    </nav>

    <h1 class="mb-4">
        <i class="bi bi-stack text-warning"></i> Stacks & Push
    </h1>

    <div class="row">
        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- Penjelasan @stack dan @push --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Konsep @@stack dan @@push</h5>
                </div>
                <div class="card-body">
                    <p>
                        <code>@@stack</code> dan <code>@@push</code> memungkinkan kita menambahkan 
                        CSS atau JavaScript khusus per halaman, tanpa mengubah layout utama.
                    </p>
                    
                    <h6>Di Layout (app.blade.php):</h6>
                    <pre class="bg-light p-3 rounded"><code>&lt;head&gt;
    ...
    @@stack('styles')  {{-- Stack untuk CSS --}}
&lt;/head&gt;
&lt;body&gt;
    ...
    @@stack('scripts') {{-- Stack untuk JS --}}
&lt;/body&gt;</code></pre>
                    
                    <h6 class="mt-3">Di Child View:</h6>
                    <pre class="bg-light p-3 rounded"><code>@@push('styles')
&lt;style&gt;
    .custom-class { color: red; }
&lt;/style&gt;
@@endpush

@@push('scripts')
&lt;script&gt;
    console.log('Loaded!');
&lt;/script&gt;
@@endpush</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- Demo hasil @@push('styles') --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Hasil @@push('styles')</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        CSS di bawah ini ditambahkan via <code>@@push('styles')</code>
                        dan hanya berlaku di halaman ini.
                    </p>
                    
                    <div class="demo-box gradient-box mb-3">
                        <h6>Gradient Box</h6>
                        <p class="mb-0">Hover untuk efek scale</p>
                    </div>
                    
                    <div class="demo-box animated-border mb-3">
                        <h6>Animated Border</h6>
                        <p class="mb-0">Border dengan gradient</p>
                    </div>
                    
                    <div class="custom-highlight">
                        <h6>Custom Highlight</h6>
                        <p class="mb-0">Styling khusus untuk callout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- @@prepend --}}
    {{-- ============================================ --}}
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">@@prepend vs @@push</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>@@push (menambah di akhir)</h6>
                    <pre class="bg-light p-3 rounded"><code>@@push('scripts')
    &lt;script src="script1.js"&gt;&lt;/script&gt;
@@endpush

@@push('scripts')
    &lt;script src="script2.js"&gt;&lt;/script&gt;
@@endpush

{{-- Hasil: --}}
&lt;script src="script1.js"&gt;&lt;/script&gt;
&lt;script src="script2.js"&gt;&lt;/script&gt;</code></pre>
                </div>
                <div class="col-md-6">
                    <h6>@@prepend (menambah di awal)</h6>
                    <pre class="bg-light p-3 rounded"><code>@@push('scripts')
    &lt;script src="script1.js"&gt;&lt;/script&gt;
@@endpush

@@prepend('scripts')
    &lt;script src="script0.js"&gt;&lt;/script&gt;
@@endprepend

{{-- Hasil: --}}
&lt;script src="script0.js"&gt;&lt;/script&gt;
&lt;script src="script1.js"&gt;&lt;/script&gt;</code></pre>
                </div>
            </div>
        </div>
    </div>

    {{-- Demo JavaScript --}}
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Demo @@push('scripts')</h5>
        </div>
        <div class="card-body">
            <p>Klik tombol di bawah untuk melihat JavaScript yang ditambahkan via @@push:</p>
            
            <button id="demoButton" class="btn btn-primary me-2">
                <i class="bi bi-hand-index"></i> Klik Saya
            </button>
            
            <button id="counterButton" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Counter: <span id="counter">0</span>
            </button>
            
            <div id="demoOutput" class="mt-3 p-3 bg-light rounded d-none">
                <i class="bi bi-check-circle text-success"></i>
                JavaScript dari @push('scripts') berjalan!
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('demo-blade.includes') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Sebelumnya
        </a>
        <a href="{{ route('demo-blade.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-house"></i> Kembali ke Index
        </a>
        <a href="{{ route('xss-lab.index') }}" class="btn btn-danger">
            Lanjut: XSS Lab <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
@endsection

{{-- ============================================ --}}
{{-- @push untuk menambahkan scripts --}}
{{-- ============================================ --}}
@push('scripts')
<script>
    // JavaScript khusus untuk halaman ini
    document.addEventListener('DOMContentLoaded', function() {
        // Demo button
        const demoButton = document.getElementById('demoButton');
        const demoOutput = document.getElementById('demoOutput');
        
        demoButton.addEventListener('click', function() {
            demoOutput.classList.remove('d-none');
            demoButton.textContent = 'Berhasil!';
            demoButton.classList.remove('btn-primary');
            demoButton.classList.add('btn-success');
        });
        
        // Counter button
        const counterButton = document.getElementById('counterButton');
        const counter = document.getElementById('counter');
        let count = 0;
        
        counterButton.addEventListener('click', function() {
            count++;
            counter.textContent = count;
        });
    });
</script>
@endpush
