{{-- ============================================ --}}
{{-- DEMO BLADE: Index --}}
{{-- Menu utama untuk demo Blade Templating --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Demo Blade Templating')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-5">
            <i class="bi bi-code-slash text-primary"></i> Demo Blade Templating
        </h1>
        <p class="lead text-muted">
            Materi Hari 4 - Bagian 1: Blade Templating Lanjutan
        </p>
    </div>

    <div class="row g-4">
        {{-- Demo 1: Directives --}}
        <div class="col-md-6">
            <div class="card h-100 border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-signpost-split"></i> Blade Directives
                    </h5>
                </div>
                <div class="card-body">
                    <p>Pelajari control flow dan loop directives:</p>
                    <ul>
                        <li><code>@@if</code>, <code>@@elseif</code>, <code>@@else</code></li>
                        <li><code>@@unless</code>, <code>@@isset</code>, <code>@@empty</code></li>
                        <li><code>@@switch</code>, <code>@@case</code></li>
                        <li><code>@@foreach</code>, <code>@@forelse</code>, <code>@@for</code></li>
                        <li><code>$loop</code> variable</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('demo-blade.directives') }}" class="btn btn-primary">
                        <i class="bi bi-play-fill"></i> Lihat Demo
                    </a>
                </div>
            </div>
        </div>

        {{-- Demo 2: Components --}}
        <div class="col-md-6">
            <div class="card h-100 border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-puzzle"></i> Blade Components
                    </h5>
                </div>
                <div class="card-body">
                    <p>Pelajari cara membuat dan menggunakan components:</p>
                    <ul>
                        <li>Anonymous Components</li>
                        <li><code>@@props</code> directive</li>
                        <li>Slots (default &amp; named)</li>
                        <li>Component attributes</li>
                        <li>Passing data ke components</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('demo-blade.components') }}" class="btn btn-success">
                        <i class="bi bi-play-fill"></i> Lihat Demo
                    </a>
                </div>
            </div>
        </div>

        {{-- Demo 3: Include & Each --}}
        <div class="col-md-6">
            <div class="card h-100 border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-box-arrow-in-right"></i> Include & Each
                    </h5>
                </div>
                <div class="card-body">
                    <p>Pelajari cara menyertakan partial views:</p>
                    <ul>
                        <li><code>@@include</code> dengan data</li>
                        <li><code>@@includeIf</code>, <code>@@includeWhen</code></li>
                        <li><code>@@includeFirst</code></li>
                        <li><code>@@each</code> untuk loop include</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('demo-blade.includes') }}" class="btn btn-info">
                        <i class="bi bi-play-fill"></i> Lihat Demo
                    </a>
                </div>
            </div>
        </div>

        {{-- Demo 4: Stacks & Push --}}
        <div class="col-md-6">
            <div class="card h-100 border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-stack"></i> Stacks & Push
                    </h5>
                </div>
                <div class="card-body">
                    <p>Pelajari cara menambahkan CSS/JS per halaman:</p>
                    <ul>
                        <li><code>@@stack</code> di layout</li>
                        <li><code>@@push</code> untuk menambahkan ke stack</li>
                        <li><code>@@prepend</code> untuk menambahkan di awal</li>
                        <li>Menambahkan styles dan scripts per halaman</li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('demo-blade.stacks') }}" class="btn btn-warning">
                        <i class="bi bi-play-fill"></i> Lihat Demo
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Link ke XSS Lab --}}
    <div class="mt-5 text-center">
        <hr>
        <p class="text-muted">Sudah selesai dengan Blade Templating?</p>
        <a href="{{ route('xss-lab.index') }}" class="btn btn-danger btn-lg">
            <i class="bi bi-shield-exclamation"></i> Lanjut ke XSS Lab
        </a>
    </div>
</div>
@endsection
