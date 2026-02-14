{{-- ============================================ --}}
{{-- DEMO BLADE: Include & Each --}}
{{-- Partial Views --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Demo: Include & Each')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('demo-blade.index') }}">Demo Blade</a></li>
            <li class="breadcrumb-item active">Include & Each</li>
        </ol>
    </nav>

    <h1 class="mb-4">
        <i class="bi bi-box-arrow-in-right text-info"></i> Include & Each
    </h1>

    <div class="row">
        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- @include --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">1. @@include</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Menyertakan partial view ke dalam view lain.</p>
                    
                    <h6>Include dengan data:</h6>
                    <div class="bg-light p-3 rounded mb-3">
                        @php $demoMessage = 'Ini pesan dari parent view!'; @endphp
                        
                        {{-- Include partial dengan data --}}
                        @include('partials.flash-messages')
                        
                        <p class="mb-0 text-success">
                            <i class="bi bi-check"></i> Flash messages partial berhasil di-include
                        </p>
                    </div>

                    <h6>@@includeWhen (conditional include):</h6>
                    <div class="bg-light p-3 rounded">
                        @php $isAdmin = true; @endphp
                        
                        @includeWhen($isAdmin, 'partials.navigation')
                        
                        <small class="text-muted">
                            Navigation partial di-include karena $isAdmin = true
                        </small>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <pre class="mb-0"><code>@@include('partials.header')
@@include('partials.card', ['ticket' => $ticket])
@@includeWhen($isAdmin, 'partials.admin-menu')
@@includeIf('partials.maybe-exists')</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- @@each --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">2. @@each (Loop Include)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Syntax: <code>@@each('view', $array, 'variableName', 'emptyView')</code>
                    </p>
                    
                    <h6>Dengan data:</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @each akan loop dan include partial untuk setiap item --}}
                            @each('partials.ticket-row', $tickets, 'ticket', 'partials.no-tickets')
                        </tbody>
                    </table>
                    
                    <h6 class="mt-4">Dengan data kosong:</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Akan menampilkan 'partials.no-tickets' karena empty --}}
                            @each('partials.ticket-row', $emptyTickets, 'ticket', 'partials.no-tickets')
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light">
                    <pre class="mb-0"><code>{{-- Sama dengan: --}}
@@forelse($tickets as $ticket)
    @@include('partials.ticket-row', ['ticket' => $ticket])
@@empty
    @@include('partials.no-tickets')
@@endforelse

{{-- Tapi lebih ringkas: --}}
@@each('partials.ticket-row', $tickets, 'ticket', 'partials.no-tickets')</code></pre>
                </div>
            </div>
        </div>
    </div>

    {{-- Partial File Examples --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-file-code"></i> Contoh Partial Files</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>partials/ticket-row.blade.php</h6>
                    <pre class="bg-light p-3 rounded"><code>&lt;tr&gt;
    &lt;td&gt;@{{ $ticket->id }}&lt;/td&gt;
    &lt;td&gt;@{{ $ticket->title }}&lt;/td&gt;
    &lt;td&gt;
        &lt;span class="badge"&gt;
            @{{ $ticket->status }}
        &lt;/span&gt;
    &lt;/td&gt;
&lt;/tr&gt;</code></pre>
                </div>
                <div class="col-md-6">
                    <h6>partials/no-tickets.blade.php</h6>
                    <pre class="bg-light p-3 rounded"><code>&lt;tr&gt;
    &lt;td colspan="4" class="text-center"&gt;
        &lt;i class="bi bi-inbox"&gt;&lt;/i&gt;
        Tidak ada tiket.
    &lt;/td&gt;
&lt;/tr&gt;</code></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('demo-blade.components') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Sebelumnya
        </a>
        <a href="{{ route('demo-blade.stacks') }}" class="btn btn-primary">
            Lanjut: Stacks & Push <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
@endsection
