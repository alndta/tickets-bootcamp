<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * TicketTest
 * 
 * Test CRUD operations untuk Ticket
 * Sesuai dengan materi Hari 3 - MVC Laravel
 */
class TicketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper: Buat user untuk testing
     */
    private function createUser(): User
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    /**
     * Helper: Data tiket valid untuk testing
     */
    private function validTicketData(): array
    {
        return [
            'title' => 'Bug: Halaman login error',
            'description' => 'Halaman login menampilkan error 500 ketika diakses',
            'priority' => 'high',
        ];
    }

    /**
     * Test 1: Test create tiket baru
     * 
     * Memastikan user bisa membuat tiket baru melalui form
     */
    public function test_create_tiket_baru(): void
    {
        $user = $this->createUser();

        // POST ke route tickets.store
        $response = $this->actingAs($user)->post(route('tickets.store'), $this->validTicketData());

        // Assert redirect ke index dengan pesan sukses
        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success');

        // Assert tiket tersimpan di database
        $this->assertDatabaseHas('tickets', [
            'title' => 'Bug: Halaman login error',
            'description' => 'Halaman login menampilkan error 500 ketika diakses',
            'priority' => 'high',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test 2: Test view detail tiket
     * 
     * Memastikan halaman detail tiket bisa diakses dan menampilkan data
     */
    public function test_view_detail_tiket(): void
    {
        $user = $this->createUser();

        // Buat tiket
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => 'Test Tiket Detail',
            'description' => 'Deskripsi tiket untuk testing view detail',
            'priority' => 'medium',
        ]);

        // GET ke route tickets.show
        $response = $this->actingAs($user)->get(route('tickets.show', $ticket));

        // Assert halaman berhasil dimuat
        $response->assertStatus(200);

        // Assert data tiket tampil di halaman
        $response->assertSee('Test Tiket Detail');
        $response->assertSee('Deskripsi tiket untuk testing view detail');
    }

    /**
     * Test 3: Test update tiket
     * 
     * Memastikan tiket bisa diupdate melalui form edit
     */
    public function test_update_tiket(): void
    {
        $user = $this->createUser();

        // Buat tiket
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => 'Tiket Sebelum Update',
            'description' => 'Deskripsi sebelum diupdate oleh user',
            'priority' => 'low',
        ]);

        // PUT ke route tickets.update dengan data baru
        $response = $this->actingAs($user)->put(route('tickets.update', $ticket), [
            'title' => 'Tiket Sesudah Update',
            'description' => 'Deskripsi sesudah diupdate oleh user',
            'status' => 'in_progress',
            'priority' => 'high',
        ]);

        // Assert redirect ke halaman show
        $response->assertRedirect(route('tickets.show', $ticket));
        $response->assertSessionHas('success');

        // Assert data terupdate di database
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'title' => 'Tiket Sesudah Update',
            'description' => 'Deskripsi sesudah diupdate oleh user',
            'status' => 'in_progress',
            'priority' => 'high',
        ]);
    }

    /**
     * Test 4: Test delete tiket
     * 
     * Memastikan tiket bisa dihapus
     */
    public function test_delete_tiket(): void
    {
        $user = $this->createUser();

        // Buat tiket
        $ticket = Ticket::create([
            'user_id' => $user->id,
            'title' => 'Tiket Akan Dihapus',
            'description' => 'Tiket ini akan dihapus untuk testing delete',
            'priority' => 'low',
        ]);

        // Pastikan tiket ada di database
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);

        // DELETE ke route tickets.destroy
        $response = $this->actingAs($user)->delete(route('tickets.destroy', $ticket));

        // Assert redirect ke index dengan pesan sukses
        $response->assertRedirect(route('tickets.index'));
        $response->assertSessionHas('success');

        // Assert tiket sudah tidak ada di database
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
