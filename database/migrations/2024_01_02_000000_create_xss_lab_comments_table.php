<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk tabel xss_lab_comments
 * 
 * KHUSUS untuk demo Stored XSS di Lab Hari 4
 * TERPISAH dari tabel comments untuk ticket (di Hari 5)
 * 
 * Alasan dipisah:
 * 1. XSS Lab tidak memerlukan authentication
 * 2. XSS Lab bisa di-reset tanpa mempengaruhi data real
 * 3. Struktur berbeda (author_name vs user_id)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xss_lab_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->string('author_name'); // Nama bebas (tanpa auth) untuk demo XSS
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xss_lab_comments');
    }
};
