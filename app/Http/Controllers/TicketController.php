<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * TicketController
 * 
 * Controller untuk mengelola CRUD Tickets
 * Sesuai dengan materi Hari 3 - MVC Laravel
 * 
 * 7 Method Resource Controller:
 * 1. index()   - Tampilkan semua tiket
 * 2. create()  - Tampilkan form buat tiket
 * 3. store()   - Simpan tiket baru
 * 4. show()    - Tampilkan detail tiket
 * 5. edit()    - Tampilkan form edit tiket
 * 6. update()  - Update tiket
 * 7. destroy() - Hapus tiket
 */
class TicketController extends Controller
{
    /**
     * Display a listing of the tickets.
     * 
     * GET /tickets
     * 
     * @return View
     */
    public function index(): View
    {
        // Mengambil semua tiket dengan eager loading user
        // Eager loading mencegah N+1 query problem
        $tickets = Ticket::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     * 
     * GET /tickets/create
     * 
     * @return View
     */
    public function create(): View
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in storage.
     * 
     * POST /tickets
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        // Jika gagal, otomatis redirect back dengan error messages
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Tambahkan user_id dari user yang sedang login
        // Untuk sementara, kita hardcode user_id = 1 (untuk testing)
        // Nanti di materi Auth akan diganti dengan auth()->id()
        $validated['user_id'] = auth()->id() ?? 1;

        // Simpan tiket baru
        $ticket = Ticket::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()
            ->route('tickets.index')
            ->with('success', 'Tiket berhasil dibuat!');
    }

    /**
     * Display the specified ticket.
     * 
     * GET /tickets/{ticket}
     * 
     * @param Ticket $ticket - Route Model Binding
     * @return View
     */
    public function show(Ticket $ticket): View
    {
        // Laravel otomatis mencari Ticket berdasarkan ID dari URL
        // Jika tidak ditemukan, otomatis return 404
        
        // Load relasi user
        $ticket->load('user');

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     * 
     * GET /tickets/{ticket}/edit
     * 
     * @param Ticket $ticket
     * @return View
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket in storage.
     * 
     * PUT/PATCH /tickets/{ticket}
     * 
     * @param Request $request
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Update tiket
        $ticket->update($validated);

        // Redirect ke halaman detail dengan pesan sukses
        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Tiket berhasil diupdate!');
    }

    /**
     * Remove the specified ticket from storage.
     * 
     * DELETE /tickets/{ticket}
     * 
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        // Hapus tiket
        $ticket->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()
            ->route('tickets.index')
            ->with('success', 'Tiket berhasil dihapus!');
    }
}
