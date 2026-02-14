<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel comments
 * 
 * Digunakan untuk komentar pada Tickets (fitur real)
 * TERPISAH dari xss_lab_comments (untuk demo XSS)
 * 
 * Perbedaan:
 * - comments: user_id (perlu auth), untuk fitur ticket
 * - xss_lab_comments: author_name (tanpa auth), untuk demo XSS
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();

            // Index untuk query yang sering dipakai
            $table->index(['ticket_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
