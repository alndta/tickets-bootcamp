<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * TicketSeeder
 * 
 * Seeder untuk mengisi data dummy tiket
 * Berguna untuk testing dan demo
 */
class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada minimal 1 user
        $user = User::first();
        
        if (!$user) {
            // Buat user demo jika belum ada
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Data tiket sample
        $tickets = [
            [
                'title' => 'Bug: Halaman login tidak bisa diakses',
                'description' => 'Ketika mencoba mengakses halaman login di /login, muncul error 500. Sudah dicoba clear cache tapi tetap sama. Browser yang digunakan Chrome versi terbaru.',
                'status' => 'open',
                'priority' => 'high',
            ],
            [
                'title' => 'Request: Fitur export ke PDF',
                'description' => 'Mohon ditambahkan fitur untuk export laporan ke format PDF. Fitur ini diperlukan untuk keperluan dokumentasi dan arsip.',
                'status' => 'in_progress',
                'priority' => 'medium',
            ],
            [
                'title' => 'Perbaikan typo di halaman About',
                'description' => 'Ada beberapa typo di halaman About Us. Contohnya "SMK Wikrama Bgor" seharusnya "SMK Wikrama Bogor".',
                'status' => 'closed',
                'priority' => 'low',
            ],
            [
                'title' => 'Error saat upload file lebih dari 2MB',
                'description' => 'Ketika mencoba upload file attachment dengan ukuran lebih dari 2MB, muncul pesan error "File too large". Apakah bisa ditingkatkan limitnya menjadi 10MB?',
                'status' => 'open',
                'priority' => 'medium',
            ],
            [
                'title' => 'Request: Dark mode',
                'description' => 'Apakah bisa ditambahkan opsi dark mode untuk website? Akan sangat membantu saat bekerja di malam hari agar tidak terlalu silau.',
                'status' => 'open',
                'priority' => 'low',
            ],
            [
                'title' => 'Bug: Notifikasi email tidak terkirim',
                'description' => 'Setelah membuat tiket baru, seharusnya ada notifikasi email yang dikirim ke admin. Tapi sepertinya email tidak terkirim. Sudah cek folder spam tapi tidak ada.',
                'status' => 'in_progress',
                'priority' => 'high',
            ],
        ];

        foreach ($tickets as $ticketData) {
            Ticket::create([
                'user_id' => $user->id,
                ...$ticketData,
            ]);
        }

        $this->command->info('Created ' . count($tickets) . ' sample tickets!');
    }
}
