{{-- ============================================ --}}
{{-- PARTIAL: Navigation --}}
{{-- Komponen navigasi yang bisa di-include --}}
{{-- ============================================ --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="bi bi-shield-lock"></i> Secure Ticketing
        </a>
        
        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#mainNavbar" aria-controls="mainNavbar" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        {{-- Navigation Items --}}
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" 
                       href="{{ url('/') }}">
                        <i class="bi bi-house"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" 
                       href="{{ route('tickets.index') }}">
                        <i class="bi bi-ticket-detailed"></i> Tickets
                    </a>
                </li>
            </ul>
            
            {{-- Right Side Navigation --}}
            <ul class="navbar-nav">
                {{-- 
                    Untuk sementara tampilkan user statis
                    Di materi Authentication nanti akan menggunakan:
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                {{ auth()->user()->name }}
                            </a>
                            ...
                        </li>
                    @endauth
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> Demo User
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
