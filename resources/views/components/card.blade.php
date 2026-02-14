{{-- ============================================ --}}
{{-- COMPONENT: Card --}}
{{-- File: resources/views/components/card.blade.php --}}
{{-- ============================================ --}}

@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title)
        <div class="card-header">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>
    @endif
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
