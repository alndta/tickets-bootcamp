<?php

namespace App\Http\Controllers;

use App\Models\XssLabComment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * XSSLabController
 * 
 * Controller untuk Lab XSS - Demonstrasi Vulnerable vs Secure
 * Sesuai dengan materi Hari 4 - Bagian 2, 3, dan 4
 * 
 * Menggunakan model XssLabComment (tabel: xss_lab_comments)
 * TERPISAH dari Comment untuk ticket (tabel: comments)
 * 
 * ⚠️ PERINGATAN: Halaman vulnerable HANYA untuk pembelajaran!
 */
class XSSLabController extends Controller
{
    /**
     * Halaman index Lab XSS
     */
    public function index(): View
    {
        return view('xss-lab.index');
    }

    // =========================================
    // REFLECTED XSS
    // =========================================

    /**
     * Reflected XSS - VULNERABLE
     * 
     * ❌ JANGAN GUNAKAN DI PRODUCTION!
     */
    public function reflectedVulnerable(Request $request): View
    {
        $searchQuery = $request->input('q', '');
        
        return view('xss-lab.vulnerable.reflected', [
            'searchQuery' => $searchQuery,
        ]);
    }

    /**
     * Reflected XSS - SECURE
     * 
     * ✅ Versi aman dengan proper escaping
     */
    public function reflectedSecure(Request $request): View
    {
        $searchQuery = $request->input('q', '');
        
        return view('xss-lab.secure.reflected', [
            'searchQuery' => $searchQuery,
        ]);
    }

    // =========================================
    // STORED XSS
    // =========================================

    /**
     * Stored XSS - VULNERABLE
     * 
     * ❌ JANGAN GUNAKAN DI PRODUCTION!
     */
    public function storedVulnerable(): View
    {
        $comments = XssLabComment::orderBy('created_at', 'desc')->get();
        $ticket = Ticket::first();
        
        return view('xss-lab.vulnerable.stored', [
            'comments' => $comments,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Stored XSS - Store Comment (VULNERABLE version)
     */
    public function storedVulnerableStore(Request $request): RedirectResponse
    {
        // ❌ VULNERABLE: Tidak ada validasi/sanitasi yang proper
        XssLabComment::create([
            'ticket_id' => $request->ticket_id ?? 1,
            'author_name' => $request->author_name,
            'content' => $request->content,
        ]);

        return redirect()->route('xss-lab.stored.vulnerable')
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Stored XSS - SECURE
     * 
     * ✅ Versi aman dengan proper validation dan escaping
     */
    public function storedSecure(): View
    {
        $comments = XssLabComment::orderBy('created_at', 'desc')->get();
        $ticket = Ticket::first();
        
        return view('xss-lab.secure.stored', [
            'comments' => $comments,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Stored XSS - Store Comment (SECURE version)
     */
    public function storedSecureStore(Request $request): RedirectResponse
    {
        // ✅ SECURE: Validasi input dengan proper rules
        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'author_name' => 'required|string|max:100',
            'content' => 'required|string|max:1000',
        ]);

        // Simpan - Blade akan auto-escape saat menampilkan
        XssLabComment::create($validated);

        return redirect()->route('xss-lab.stored.secure')
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    // =========================================
    // DOM-BASED XSS
    // =========================================

    /**
     * DOM-Based XSS - VULNERABLE
     */
    public function domVulnerable(): View
    {
        return view('xss-lab.vulnerable.dom-based');
    }

    /**
     * DOM-Based XSS - SECURE
     */
    public function domSecure(): View
    {
        return view('xss-lab.secure.dom-based');
    }

    // =========================================
    // UTILITY
    // =========================================

    /**
     * Reset comments (untuk demo ulang)
     * Hanya menghapus xss_lab_comments, TIDAK mempengaruhi comments ticket
     */
    public function resetComments(): RedirectResponse
    {
        XssLabComment::truncate();
        
        return redirect()->route('xss-lab.index')
            ->with('success', 'Semua komentar XSS Lab berhasil dihapus!');
    }
}
