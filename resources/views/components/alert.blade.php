{{-- ============================================ --}}
{{-- COMPONENT: Alert --}}
{{-- File: resources/views/components/alert.blade.php --}}
{{-- ============================================ --}}

@props(['type' => 'info', 'message', 'dismissible' => true])

@php
    $typeClasses = [
        'success' => 'alert-success',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];
    
    $icons = [
        'success' => 'bi-check-circle-fill',
        'danger' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-circle-fill',
        'info' => 'bi-info-circle-fill',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'alert ' . ($typeClasses[$type] ?? 'alert-info') . ($dismissible ? ' alert-dismissible fade show' : '')]) }} role="alert">
    <i class="bi {{ $icons[$type] ?? 'bi-info-circle-fill' }} me-2"></i>
    {{ $message }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
