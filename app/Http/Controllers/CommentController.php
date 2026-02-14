<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * CommentController
 * 
 * Controller untuk mengelola komentar pada tickets
 * Implementasi secure coding untuk XSS prevention
 * 
 * Materi Hari 5 - Lab Lengkap XSS Prevention
 */
class CommentController extends Controller
{
    /**
     * Store a new comment.
     * 
     * SECURITY MEASURES:
     * 1. Input Validation - memastikan content sesuai aturan
     * 2. Sanitization - strip_tags() untuk hapus HTML
     * 3. Authentication - hanya user login yang bisa comment
     * 4. CSRF Protection - Laravel otomatis handle via middleware
     */
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        // ✅ STEP 1: VALIDASI INPUT
        // Memastikan content:
        // - required: tidak boleh kosong
        // - string: harus berupa string
        // - min:3: minimal 3 karakter
        // - max:2000: maksimal 2000 karakter
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:2000',
        ], [
            'content.required' => 'Komentar tidak boleh kosong.',
            'content.min' => 'Komentar minimal 3 karakter.',
            'content.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        // ✅ STEP 2: SANITASI INPUT
        // strip_tags() menghapus semua HTML tags dari input
        // Ini adalah layer pertama defense against XSS
        // 
        // Input: "<script>alert('XSS')</script>Halo"
        // Output: "Halo"
        $cleanContent = strip_tags($validated['content']);

        // ✅ STEP 3: SIMPAN KE DATABASE
        // Data yang disimpan sudah bersih dari HTML tags
        // Tapi tetap, di view kita akan menggunakan {{ }} untuk auto-escape
        // Ini adalah defense in depth - multiple layers of protection
        
        // ⚠️ TEMPORARY: Hardcode user_id = 1 (demo user dari seeder)
        // TODO: Ganti dengan Auth::id() di Minggu 4 setelah implementasi Authentication
        // Contoh nanti: 'user_id' => Auth::id(),
        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => 1, // TEMPORARY - akan diganti Auth::id() di Minggu 4
            'content' => $cleanContent,
        ]);

        // ✅ STEP 4: REDIRECT DENGAN FLASH MESSAGE
        // Flash message juga akan di-escape di view dengan {{ }}
        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Delete a comment.
     * 
     * SECURITY MEASURES:
     * 1. Authorization - hanya owner atau admin yang bisa delete
     * 2. CSRF Protection - via @method('DELETE') dan @csrf
     * 3. Route Model Binding - Laravel otomatis validasi comment exists
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // ✅ AUTHORIZATION CHECK
        // Pastikan user adalah:
        // 1. Pemilik komentar, ATAU
        // 2. Admin
        //
        // ⚠️ TEMPORARY: Skip auth check sampai Minggu 4
        // TODO: Uncomment kode di bawah setelah implementasi Authentication
        /*
        if (Auth::id() !== $comment->user_id) {
            // Check apakah user adalah admin
            // Asumsikan ada kolom is_admin atau role di tabel users
            $isAdmin = Auth::user()->is_admin ?? false;
            
            if (!$isAdmin) {
                // Unauthorized - return 403 Forbidden
                abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
            }
        }
        */

        // Simpan ticket untuk redirect
        $ticket = $comment->ticket;

        // ✅ DELETE COMMENT
        $comment->delete();

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Update a comment.
     * 
     * Optional: Jika ingin menambahkan fitur edit comment
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        // ✅ AUTHORIZATION
        // ⚠️ TEMPORARY: Skip auth check sampai Minggu 4
        // TODO: Uncomment kode di bawah setelah implementasi Authentication
        /*
        if (Auth::id() !== $comment->user_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }
        */

        // ✅ VALIDASI
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:2000',
        ]);

        // ✅ SANITASI
        $cleanContent = strip_tags($validated['content']);

        // ✅ UPDATE
        $comment->update([
            'content' => $cleanContent,
        ]);

        return redirect()
            ->route('tickets.show', $comment->ticket)
            ->with('success', 'Komentar berhasil diperbarui!');
    }
}
