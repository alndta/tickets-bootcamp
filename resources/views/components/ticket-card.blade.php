{{-- ============================================ --}}
{{-- COMPONENT: Ticket Card --}}
{{-- File: resources/views/components/ticket-card.blade.php --}}
{{-- ============================================ --}}

@props(['ticket'])

@php
    $statusColors = [
        'open' => 'warning',
        'in_progress' => 'info',
        'closed' => 'success',
    ];
    
    $priorityColors = [
        'low' => 'secondary',
        'medium' => 'primary',
        'high' => 'danger',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'card mb-3']) }}>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h5 class="card-title mb-1">
                    {{-- PENTING: Menggunakan {{ }} untuk auto-escape --}}
                    {{ $ticket->title }}
                </h5>
                <p class="card-text text-muted small mb-2">
                    Tiket #{{ $ticket->id }}
                </p>
            </div>
            <div>
                <x-badge :type="$statusColors[$ticket->status] ?? 'secondary'">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </x-badge>
                <x-badge :type="$priorityColors[$ticket->priority] ?? 'secondary'">
                    {{ ucfirst($ticket->priority) }}
                </x-badge>
            </div>
        </div>
        
        {{-- Slot untuk konten tambahan --}}
        @if($slot->isNotEmpty())
            <div class="mt-3">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
