<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Comment
 * 
 * Untuk komentar pada Tickets (fitur real aplikasi)
 * Memerlukan authentication (user_id)
 * 
 * TERPISAH dari XssLabComment yang digunakan untuk demo XSS
 * 
 * Tabel: comments
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'content',
    ];

    /**
     * Relasi: Comment belongs to Ticket
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Relasi: Comment belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
