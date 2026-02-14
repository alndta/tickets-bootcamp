{{-- ============================================ --}}
{{-- COMPONENT: Badge --}}
{{-- File: resources/views/components/badge.blade.php --}}
{{-- ============================================ --}}

@props(['type' => 'primary', 'pill' => false])

@php
    $classes = 'badge bg-' . $type;
    if ($pill) {
        $classes .= ' rounded-pill';
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
