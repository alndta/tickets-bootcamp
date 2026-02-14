<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Secure Ticketing') - SMK Wikrama Bogor</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .footer {
            background-color: #212529;
            color: #fff;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- ============================================ --}}
    {{-- NAVIGATION --}}
    {{-- ============================================ --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-shield-lock"></i> Secure Ticketing
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" 
                           href="{{ route('tickets.index') }}">
                            <i class="bi bi-ticket-detailed"></i> Tickets
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    {{-- Untuk sementara tampilkan user statis --}}
                    {{-- Nanti di materi Auth akan diganti dengan @auth/@guest --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" 
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> User Demo
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ============================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================ --}}
    <main class="container py-4">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page Content --}}
        @yield('content')
    </main>

    {{-- ============================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================ --}}
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-1">
                <i class="bi bi-shield-lock"></i> Secure Ticketing System
            </p>
            <p class="mb-0 text-muted">
                &copy; {{ date('Y') }} Bootcamp Secure Coding - SMK Wikrama Bogor
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
