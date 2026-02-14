{{-- ============================================ --}}
{{-- DEMO BLADE: Components --}}
{{-- Blade Components & Slots --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Demo: Blade Components')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('demo-blade.index') }}">Demo Blade</a></li>
            <li class="breadcrumb-item active">Components</li>
        </ol>
    </nav>

    <h1 class="mb-4">
        <i class="bi bi-puzzle text-success"></i> Blade Components
    </h1>

    <div class="row">
        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- ALERT COMPONENT --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">1. Alert Component</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Component: <code>resources/views/components/alert.blade.php</code>
                    </p>
                    
                    {{-- Penggunaan component x-alert --}}
                    <x-alert type="success" message="Ini adalah alert sukses!" />
                    <x-alert type="danger" message="Ini adalah alert error!" />
                    <x-alert type="warning" message="Ini adalah alert warning!" />
                    <x-alert type="info" message="Ini adalah alert info!" :dismissible="false" />
                </div>
                <div class="card-footer bg-light">
                    <small><strong>Penggunaan:</strong></small>
                    <pre class="mb-0 mt-2"><code>&lt;x-alert type="success" message="Pesan sukses!" /&gt;
&lt;x-alert type="danger" :message="$errorVar" /&gt;
&lt;x-alert type="info" message="Info" :dismissible="false" /&gt;</code></pre>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- BADGE COMPONENT --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">2. Badge Component</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Component: <code>resources/views/components/badge.blade.php</code>
                    </p>
                    
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        <x-badge type="primary">Primary</x-badge>
                        <x-badge type="secondary">Secondary</x-badge>
                        <x-badge type="success">Success</x-badge>
                        <x-badge type="danger">Danger</x-badge>
                        <x-badge type="warning">Warning</x-badge>
                        <x-badge type="info">Info</x-badge>
                    </div>
                    
                    <p class="mb-2">Dengan pill style:</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <x-badge type="primary" :pill="true">Pill Badge</x-badge>
                        <x-badge type="success" :pill="true">Another Pill</x-badge>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <small><strong>Penggunaan:</strong></small>
                    <pre class="mb-0 mt-2"><code>&lt;x-badge type="success"&gt;Label&lt;/x-badge&gt;
&lt;x-badge type="danger" :pill="true"&gt;Pill&lt;/x-badge&gt;</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- CARD COMPONENT --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">3. Card Component (dengan Slot)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Component: <code>resources/views/components/card.blade.php</code>
                    </p>
                    
                    {{-- Penggunaan x-card dengan slot --}}
                    <x-card title="Judul Card">
                        <p>Ini adalah konten di dalam <strong>slot</strong> default.</p>
                        <p class="mb-0">Slot memungkinkan kita memasukkan HTML apapun ke dalam component.</p>
                    </x-card>
                    
                    <div class="mt-3">
                        <x-card title="Card dengan Attributes" class="border-primary">
                            <p class="mb-0">Card ini memiliki class tambahan <code>border-primary</code></p>
                        </x-card>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <small><strong>Penggunaan:</strong></small>
                    <pre class="mb-0 mt-2"><code>&lt;x-card title="Judul"&gt;
    &lt;p&gt;Konten dalam slot&lt;/p&gt;
&lt;/x-card&gt;

&lt;x-card title="Custom" class="border-primary"&gt;
    Dengan attributes tambahan
&lt;/x-card&gt;</code></pre>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- TICKET CARD COMPONENT --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">4. Ticket Card Component</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Component: <code>resources/views/components/ticket-card.blade.php</code>
                    </p>
                    
                    {{-- Penggunaan x-ticket-card --}}
                    <x-ticket-card :ticket="$ticket">
                        <p class="mb-2">{{ Str::limit($ticket->description ?? 'Deskripsi tiket...', 100) }}</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </x-ticket-card>
                </div>
                <div class="card-footer bg-light">
                    <small><strong>Penggunaan:</strong></small>
                    <pre class="mb-0 mt-2"><code>&lt;x-ticket-card :ticket="$ticket"&gt;
    &lt;p&gt;@{{ $ticket->description }}&lt;/p&gt;
    &lt;a href="#"&gt;Lihat Detail&lt;/a&gt;
&lt;/x-ticket-card&gt;</code></pre>
                </div>
            </div>
        </div>
    </div>

    {{-- @props Explanation --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-code-slash"></i> Anatomi Component</h5>
        </div>
        <div class="card-body">
            <pre class="bg-light p-3 rounded"><code>{{-- File: resources/views/components/alert.blade.php --}}

{{-- @props mendefinisikan parameters yang diterima component --}}
@props(['type' => 'info', 'message', 'dismissible' => true])

{{-- $attributes berisi semua attribute HTML yang tidak ada di @props --}}
&lt;div @{{ $attributes->merge(['class' => 'alert alert-' . $type]) }}&gt;
    @{{ $message }}
    
    @if($dismissible)
        &lt;button type="button" class="btn-close"&gt;&lt;/button&gt;
    @endif
&lt;/div&gt;

{{-- Penggunaan: --}}
&lt;x-alert type="success" message="Berhasil!" /&gt;
&lt;x-alert type="danger" :message="$error" class="mt-3" /&gt;</code></pre>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('demo-blade.directives') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Sebelumnya
        </a>
        <a href="{{ route('demo-blade.includes') }}" class="btn btn-primary">
            Lanjut: Include & Each <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
@endsection
