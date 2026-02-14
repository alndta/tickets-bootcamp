{{-- ============================================ --}}
{{-- PARTIAL: Ticket Row --}}
{{-- Untuk demo @each directive --}}
{{-- ============================================ --}}

<tr>
    <td>{{ $ticket->id }}</td>
    <td>{{ $ticket->title }}</td>
    <td>
        <span class="badge bg-{{ $ticket->status === 'open' ? 'warning' : ($ticket->status === 'in_progress' ? 'info' : 'success') }}">
            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
        </span>
    </td>
    <td>
        <span class="badge bg-{{ $ticket->priority === 'high' ? 'danger' : ($ticket->priority === 'medium' ? 'primary' : 'secondary') }}">
            {{ ucfirst($ticket->priority) }}
        </span>
    </td>
</tr>
