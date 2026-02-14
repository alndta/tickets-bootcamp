{{-- ============================================ --}}
{{-- Security Testing - Audit Checklist --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Security Audit Checklist - Security Dashboard')

@push('styles')
<style>
    .checklist-item {
        transition: background-color 0.2s ease;
    }
    .checklist-item:hover {
        background-color: #f8f9fa;
    }
    .checklist-item.checked {
        background-color: #d4edda;
    }
    .progress-ring {
        width: 100px;
        height: 100px;
    }
    .progress-ring-circle {
        transition: stroke-dashoffset 0.3s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>
                <i class="bi bi-clipboard-check text-warning"></i> Security Audit Checklist
            </h2>
            <p class="text-muted mb-0">
                Checklist keamanan sebelum deployment ke production
            </p>
        </div>
        <a href="{{ route('security-testing.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Progress Overview --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <svg class="progress-ring" viewBox="0 0 36 36">
                        <path
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                            fill="none"
                            stroke="#e9ecef"
                            stroke-width="3"
                        />
                        <path
                            id="progressCircle"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                            fill="none"
                            stroke="#28a745"
                            stroke-width="3"
                            stroke-dasharray="0, 100"
                            class="progress-ring-circle"
                        />
                        <text x="18" y="20.35" class="progress-text" text-anchor="middle" font-size="8">
                            <tspan id="progressPercent">0%</tspan>
                        </text>
                    </svg>
                    <p class="text-muted small mt-2 mb-0">Progress</p>
                </div>
                <div class="col-md-9">
                    <h5>Security Audit Progress</h5>
                    <p class="text-muted small mb-2">
                        Checklist keamanan yang harus dipenuhi sebelum aplikasi di-deploy
                    </p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" 
                             role="progressbar" 
                             id="progressBar"
                             style="width: 0%">
                            <span id="progressText">0 / 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Checklist Sections --}}
    <div class="row g-4">
        @foreach($checklist as $key => $section)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            @switch($key)
                                @case('xss')
                                    <i class="bi bi-shield-exclamation text-danger"></i>
                                    @break
                                @case('csrf')
                                    <i class="bi bi-key text-primary"></i>
                                    @break
                                @case('input')
                                    <i class="bi bi-input-cursor text-success"></i>
                                    @break
                                @case('headers')
                                    <i class="bi bi-server text-info"></i>
                                    @break
                                @case('auth')
                                    <i class="bi bi-person-lock text-warning"></i>
                                    @break
                            @endswitch
                            {{ $section['title'] }}
                        </h6>
                        <span class="badge bg-secondary section-badge" data-section="{{ $key }}">
                            0 / {{ count($section['items']) }}
                        </span>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($section['items'] as $index => $item)
                            <li class="list-group-item checklist-item d-flex align-items-center">
                                <input type="checkbox" 
                                       class="form-check-input me-3 checklist-checkbox"
                                       id="check-{{ $key }}-{{ $index }}"
                                       data-section="{{ $key }}"
                                       onchange="updateProgress()">
                                <label for="check-{{ $key }}-{{ $index }}" 
                                       class="mb-0 flex-grow-1 small">
                                    {{ $item }}
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Additional Checks --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle"></i> Additional Security Checks
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="bi bi-file-earmark-code"></i> Dependencies</h6>
                            <ul class="small mb-0">
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    <code>composer audit</code> - no vulnerabilities
                                </li>
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    <code>npm audit</code> - no vulnerabilities
                                </li>
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    All packages up to date
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6><i class="bi bi-gear"></i> Configuration</h6>
                            <ul class="small mb-0">
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    APP_DEBUG=false in production
                                </li>
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    APP_ENV=production
                                </li>
                                <li class="checklist-item p-1">
                                    <input type="checkbox" class="form-check-input me-2 checklist-checkbox" 
                                           onchange="updateProgress()">
                                    .env not in version control
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-success" onclick="checkAll()">
                    <i class="bi bi-check-all"></i> Check All
                </button>
                <button class="btn btn-outline-secondary" onclick="uncheckAll()">
                    <i class="bi bi-x-lg"></i> Uncheck All
                </button>
                <button class="btn btn-outline-primary" onclick="exportChecklist()">
                    <i class="bi bi-download"></i> Export Report
                </button>
                <button class="btn btn-outline-info" onclick="saveProgress()">
                    <i class="bi bi-save"></i> Save to LocalStorage
                </button>
            </div>
        </div>
    </div>

    {{-- Quick Commands --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <i class="bi bi-terminal"></i> Quick Security Commands
            </h5>
        </div>
        <div class="card-body bg-dark text-white">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted small mb-1"># Laravel Security Check</p>
                    <pre class="mb-3"><code>composer require enlightn/security-checker --dev
php artisan security:check</code></pre>
                    
                    <p class="text-muted small mb-1"># Composer Audit</p>
                    <pre class="mb-3"><code>composer audit</code></pre>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1"># NPM Audit</p>
                    <pre class="mb-3"><code>npm audit
npm audit fix</code></pre>
                    
                    <p class="text-muted small mb-1"># Check Security Headers</p>
                    <pre class="mb-0"><code>curl -I {{ url('/') }}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Load saved progress
    document.addEventListener('DOMContentLoaded', function() {
        loadProgress();
        updateProgress();
    });

    function updateProgress() {
        const checkboxes = document.querySelectorAll('.checklist-checkbox');
        const checked = document.querySelectorAll('.checklist-checkbox:checked');
        
        const total = checkboxes.length;
        const completed = checked.length;
        const percent = total > 0 ? Math.round((completed / total) * 100) : 0;
        
        // Update progress bar
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressText').textContent = `${completed} / ${total}`;
        
        // Update progress ring
        document.getElementById('progressPercent').textContent = percent + '%';
        const circle = document.getElementById('progressCircle');
        circle.setAttribute('stroke-dasharray', `${percent}, 100`);
        
        // Update section badges
        const sections = ['xss', 'csrf', 'input', 'headers', 'auth'];
        sections.forEach(section => {
            const sectionCheckboxes = document.querySelectorAll(`[data-section="${section}"]`);
            const sectionChecked = document.querySelectorAll(`[data-section="${section}"]:checked`);
            const badge = document.querySelector(`.section-badge[data-section="${section}"]`);
            if (badge) {
                badge.textContent = `${sectionChecked.length} / ${sectionCheckboxes.length}`;
                badge.className = sectionChecked.length === sectionCheckboxes.length 
                    ? 'badge bg-success section-badge' 
                    : 'badge bg-secondary section-badge';
            }
        });
        
        // Update item styling
        checkboxes.forEach(cb => {
            const item = cb.closest('.checklist-item');
            if (item) {
                if (cb.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }
            }
        });
    }

    function checkAll() {
        document.querySelectorAll('.checklist-checkbox').forEach(cb => cb.checked = true);
        updateProgress();
    }

    function uncheckAll() {
        document.querySelectorAll('.checklist-checkbox').forEach(cb => cb.checked = false);
        updateProgress();
    }

    function saveProgress() {
        const state = {};
        document.querySelectorAll('.checklist-checkbox').forEach(cb => {
            state[cb.id] = cb.checked;
        });
        localStorage.setItem('securityAuditChecklist', JSON.stringify(state));
        alert('Progress saved to localStorage!');
    }

    function loadProgress() {
        const saved = localStorage.getItem('securityAuditChecklist');
        if (saved) {
            const state = JSON.parse(saved);
            Object.keys(state).forEach(id => {
                const cb = document.getElementById(id);
                if (cb) cb.checked = state[id];
            });
        }
    }

    function exportChecklist() {
        const checkboxes = document.querySelectorAll('.checklist-checkbox');
        let report = '# Security Audit Report\n';
        report += `Date: ${new Date().toISOString()}\n\n`;
        
        let completed = 0;
        let total = checkboxes.length;
        
        checkboxes.forEach(cb => {
            const label = cb.nextElementSibling?.textContent || cb.parentElement.textContent;
            const status = cb.checked ? '✅' : '❌';
            report += `${status} ${label.trim()}\n`;
            if (cb.checked) completed++;
        });
        
        report += `\n## Summary\n`;
        report += `Completed: ${completed}/${total} (${Math.round(completed/total*100)}%)\n`;
        
        // Download as text file
        const blob = new Blob([report], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'security-audit-report.txt';
        a.click();
        URL.revokeObjectURL(url);
    }
</script>
@endpush
@endsection
