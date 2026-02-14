<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Ticket
 * 
 * Representasi dari tabel 'tickets' di database
 * Sesuai dengan materi Hari 3 - MVC Laravel
 */
class Ticket extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara mass-assignment
     * 
     * PENTING untuk keamanan!
     * Hanya kolom yang didefinisikan di sini yang bisa diisi via create() atau update()
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
    ];

    /**
     * Casting tipe data otomatis
     * 
     * Laravel akan otomatis mengkonversi tipe data saat mengambil/menyimpan
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Nilai default untuk atribut
     * 
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'open',
        'priority' => 'medium',
    ];

    /**
     * Relasi: Ticket belongs to User
     * 
     * Setiap tiket dimiliki oleh satu user
     * Penggunaan: $ticket->user->name
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter tiket berdasarkan status
     * 
     * Penggunaan: Ticket::status('open')->get()
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter tiket berdasarkan prioritas
     * 
     * Penggunaan: Ticket::priority('high')->get()
     */
    public function scopePriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Accessor untuk mendapatkan badge class berdasarkan status
     * 
     * Penggunaan: $ticket->status_badge
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'open' => 'bg-warning',
            'in_progress' => 'bg-info',
            'closed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Accessor untuk mendapatkan badge class berdasarkan prioritas
     * 
     * Penggunaan: $ticket->priority_badge
     */
    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => 'bg-secondary',
            'medium' => 'bg-primary',
            'high' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
