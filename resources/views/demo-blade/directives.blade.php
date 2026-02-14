{{-- ============================================ --}}
{{-- DEMO BLADE: Directives --}}
{{-- Control Flow & Loop Directives --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Demo: Blade Directives')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('demo-blade.index') }}">Demo Blade</a></li>
            <li class="breadcrumb-item active">Directives</li>
        </ol>
    </nav>

    <h1 class="mb-4">
        <i class="bi bi-signpost-split text-primary"></i> Blade Directives
    </h1>

    <div class="row">
        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- CONDITIONAL DIRECTIVES --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">1. Conditional Directives</h5>
                </div>
                <div class="card-body">
                    <h6>@@if / @@elseif / @@else</h6>
                    <div class="bg-light p-3 rounded mb-3">
                        @if($user->role === 'admin')
                            <p class="mb-0 text-success">
                                <i class="bi bi-shield-check"></i> Welcome, Admin! (role = admin)
                            </p>
                        @elseif($user->role === 'moderator')
                            <p class="mb-0 text-info">
                                <i class="bi bi-person-badge"></i> Welcome, Moderator!
                            </p>
                        @else
                            <p class="mb-0 text-muted">
                                <i class="bi bi-person"></i> Welcome, Guest!
                            </p>
                        @endif
                    </div>

                    <h6>@@unless (kebalikan dari @@if)</h6>
                    <div class="bg-light p-3 rounded mb-3">
                        @unless($user->role === 'guest')
                            <p class="mb-0">
                                <i class="bi bi-box-arrow-right"></i> 
                                User bukan guest, tampilkan tombol logout
                            </p>
                        @endunless
                    </div>

                    <h6>@@isset dan @@empty</h6>
                    <div class="bg-light p-3 rounded">
                        @isset($tickets)
                            <p class="mb-1 text-success">
                                <i class="bi bi-check"></i> Variable $tickets tersedia
                            </p>
                        @endisset

                        @empty($tickets)
                            <p class="mb-0 text-warning">
                                <i class="bi bi-exclamation"></i> $tickets kosong
                            </p>
                        @else
                            <p class="mb-0 text-success">
                                <i class="bi bi-check"></i> $tickets ada {{ count($tickets) }} item
                            </p>
                        @endempty
                    </div>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- SWITCH CASE --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">2. Switch Case</h5>
                </div>
                <div class="card-body">
                    @foreach($tickets->take(3) as $ticket)
                        <div class="d-flex align-items-center mb-2">
                            <span class="me-2">{{ $ticket->title }}:</span>
                            @switch($ticket->status)
                                @case('open')
                                    <span class="badge bg-warning">🟡 Open</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-info">🔵 In Progress</span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-success">🟢 Closed</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Unknown</span>
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            {{-- ============================================ --}}
            {{-- LOOP DIRECTIVES --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">3. Loop Directives</h5>
                </div>
                <div class="card-body">
                    <h6>@@foreach dengan $loop variable</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>$loop->iteration</th>
                                <th>Title</th>
                                <th>$loop->first</th>
                                <th>$loop->last</th>
                                <th>$loop->even</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="{{ $loop->even ? 'table-light' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ticket->title }}</td>
                                    <td>{{ $loop->first ? '✅' : '❌' }}</td>
                                    <td>{{ $loop->last ? '✅' : '❌' }}</td>
                                    <td>{{ $loop->even ? '✅' : '❌' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <small class="text-muted">
                        Total: {{ $tickets->count() }} items | 
                        Remaining di akhir: 0
                    </small>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- FORELSE --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">4. @@forelse (dengan empty state)</h5>
                </div>
                <div class="card-body">
                    <h6>Data tersedia:</h6>
                    <ul class="list-group mb-3">
                        @forelse($tickets->take(3) as $ticket)
                            <li class="list-group-item">
                                {{ $loop->iteration }}. {{ $ticket->title }}
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Tidak ada data</li>
                        @endforelse
                    </ul>

                    <h6>Data kosong (simulasi):</h6>
                    <ul class="list-group">
                        @forelse([] as $item)
                            <li class="list-group-item">{{ $item }}</li>
                        @empty
                            <li class="list-group-item text-muted text-center">
                                <i class="bi bi-inbox"></i> Tidak ada data
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- ============================================ --}}
            {{-- NESTED LOOP --}}
            {{-- ============================================ --}}
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">5. Nested Loop ($loop->parent)</h5>
                </div>
                <div class="card-body">
                    @foreach($categories as $category)
                        <div class="mb-3">
                            <h6 class="text-primary">
                                {{ $loop->iteration }}. {{ $category->name }}
                                <small class="text-muted">(depth: {{ $loop->depth }})</small>
                            </h6>
                            <ul class="list-group list-group-flush">
                                @foreach($category->items as $item)
                                    <li class="list-group-item py-1 ps-4">
                                        <small>
                                            Parent: {{ $loop->parent->iteration }} |
                                            Item: {{ $loop->iteration }} |
                                            Depth: {{ $loop->depth }}
                                        </small>
                                        <br>
                                        {{ $item->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Code Example --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-code-slash"></i> Contoh Kode</h5>
        </div>
        <div class="card-body">
            <pre class="bg-light p-3 rounded"><code>{{-- Contoh penggunaan $loop variable --}}
@@foreach($tickets as $ticket)
    &lt;tr class="@{{ $loop->even ? 'bg-gray' : '' }}"&gt;
        &lt;td&gt;@{{ $loop->iteration }}&lt;/td&gt;
        &lt;td&gt;@{{ $ticket->title }}&lt;/td&gt;
        @@if($loop->first)
            &lt;td&gt;Ini item pertama!&lt;/td&gt;
        @@endif
        @@if($loop->last)
            &lt;td&gt;Total: @{{ $loop->count }} items&lt;/td&gt;
        @@endif
    &lt;/tr&gt;
@@endforeach</code></pre>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('demo-blade.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('demo-blade.components') }}" class="btn btn-primary">
            Lanjut: Components <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>
@endsection
