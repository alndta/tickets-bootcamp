<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Membuat tabel tickets untuk sistem ticketing
     * Sesuai dengan materi Hari 3 - MVC Laravel
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            // Primary key auto-increment
            $table->id();
            
            // Foreign key ke tabel users
            // onDelete('cascade') = jika user dihapus, tiketnya juga terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Judul tiket - wajib diisi, max 255 karakter
            $table->string('title');
            
            // Deskripsi tiket - text panjang
            $table->text('description');
            
            // Status tiket dengan nilai default 'open'
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open');
            
            // Prioritas tiket dengan nilai default 'medium'
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Timestamps: created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
