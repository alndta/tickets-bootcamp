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
        pre code {
            font-size: 0.85rem;
        }
    </style>
    
    {{-- Stack untuk CSS tambahan per halaman --}}
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
                    {{-- Tickets --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" 
                           href="{{ route('tickets.index') }}">
                            <i class="bi bi-ticket-detailed"></i> Tickets
                        </a>
                    </li>
                    
                    {{-- Demo Blade (Hari 4) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('demo-blade.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-code-slash"></i> Demo Blade
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('demo-blade.index') }}">
                                <i class="bi bi-house"></i> Overview
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('demo-blade.directives') }}">
                                <i class="bi bi-signpost-split"></i> Directives
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('demo-blade.components') }}">
                                <i class="bi bi-puzzle"></i> Components
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('demo-blade.includes') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Include & Each
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('demo-blade.stacks') }}">
                                <i class="bi bi-stack"></i> Stacks & Push
                            </a></li>
                        </ul>
                    </li>
                    
                    {{-- XSS Lab (Hari 4) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('xss-lab.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-exclamation"></i> XSS Lab
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('xss-lab.index') }}">
                                <i class="bi bi-house"></i> Overview
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Reflected XSS</li>
                            <li><a class="dropdown-item text-danger" href="{{ route('xss-lab.reflected.vulnerable') }}">
                                <i class="bi bi-unlock"></i> Vulnerable
                            </a></li>
                            <li><a class="dropdown-item text-success" href="{{ route('xss-lab.reflected.secure') }}">
                                <i class="bi bi-lock"></i> Secure
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">Stored XSS</li>
                            <li><a class="dropdown-item text-danger" href="{{ route('xss-lab.stored.vulnerable') }}">
                                <i class="bi bi-unlock"></i> Vulnerable
                            </a></li>
                            <li><a class="dropdown-item text-success" href="{{ route('xss-lab.stored.secure') }}">
                                <i class="bi bi-lock"></i> Secure
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li class="dropdown-header">DOM-Based XSS</li>
                            <li><a class="dropdown-item text-danger" href="{{ route('xss-lab.dom.vulnerable') }}">
                                <i class="bi bi-unlock"></i> Vulnerable
                            </a></li>
                            <li><a class="dropdown-item text-success" href="{{ route('xss-lab.dom.secure') }}">
                                <i class="bi bi-lock"></i> Secure
                            </a></li>
                        </ul>
                    </li>
                    
                    {{-- Security Testing (Hari 5) - NEW --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('security-testing.*') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shield-shaded"></i> Security Testing
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('security-testing.index') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('security-testing.xss') }}">
                                <i class="bi bi-shield-exclamation text-danger"></i> XSS Test
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('security-testing.csrf') }}">
                                <i class="bi bi-key text-primary"></i> CSRF Test
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('security-testing.headers') }}">
                                <i class="bi bi-server text-info"></i> Headers Test
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('security-testing.audit') }}">
                                <i class="bi bi-clipboard-check text-warning"></i> Audit Checklist
                            </a></li>
                        </ul>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" 
                               data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endauth
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
            <p class="mb-0 mt-2">
                <small class="text-muted">
                    <span class="badge bg-success">Hari 3: MVC</span>
                    <span class="badge bg-info">Hari 4: Blade & XSS</span>
                    <span class="badge bg-warning text-dark">Hari 5: Lab Lengkap</span>
                </small>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Stack untuk JavaScript tambahan per halaman --}}
    @stack('scripts')
</body>
</html>
