<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * DemoBladeController
 * 
 * Controller untuk mendemonstrasikan fitur-fitur Blade Templating
 * Sesuai dengan materi Hari 4 - Bagian 1
 */
class DemoBladeController extends Controller
{
    /**
     * Halaman index demo Blade
     */
    public function index(): View
    {
        return view('demo-blade.index');
    }

    /**
     * Demo Blade Directives (Control Flow & Loops)
     */
    public function directives(): View
    {
        // Data untuk demo
        $user = (object) [
            'name' => 'Demo User',
            'role' => 'admin', // Coba ganti: 'admin', 'moderator', 'guest'
            'isAdmin' => fn() => true,
            'isModerator' => fn() => false,
            'isGuest' => fn() => false,
        ];

        // Data tiket untuk demo loop
        $tickets = Ticket::take(5)->get();
        
        // Jika belum ada tiket, buat data dummy
        if ($tickets->isEmpty()) {
            $tickets = collect([
                (object) ['id' => 1, 'title' => 'Bug Login', 'status' => 'open', 'priority' => 'high'],
                (object) ['id' => 2, 'title' => 'Request Fitur', 'status' => 'in_progress', 'priority' => 'medium'],
                (object) ['id' => 3, 'title' => 'Typo di About', 'status' => 'closed', 'priority' => 'low'],
                (object) ['id' => 4, 'title' => 'Error Upload', 'status' => 'open', 'priority' => 'high'],
                (object) ['id' => 5, 'title' => 'Dark Mode', 'status' => 'open', 'priority' => 'low'],
            ]);
        }

        // Data untuk nested loop
        $categories = collect([
            (object) [
                'name' => 'Bug Reports',
                'items' => collect([
                    (object) ['name' => 'Login Bug'],
                    (object) ['name' => 'Upload Error'],
                ])
            ],
            (object) [
                'name' => 'Feature Requests',
                'items' => collect([
                    (object) ['name' => 'Dark Mode'],
                    (object) ['name' => 'Export PDF'],
                    (object) ['name' => 'Mobile App'],
                ])
            ],
        ]);

        return view('demo-blade.directives', compact('user', 'tickets', 'categories'));
    }

    /**
     * Demo Blade Components
     */
    public function components(): View
    {
        $ticket = Ticket::first() ?? (object) [
            'id' => 1,
            'title' => 'Sample Ticket',
            'description' => 'Ini adalah deskripsi tiket untuk demo component',
            'status' => 'open',
            'priority' => 'high',
            'created_at' => now(),
        ];

        return view('demo-blade.components', compact('ticket'));
    }

    /**
     * Demo Include & Each
     */
    public function includes(): View
    {
        $tickets = Ticket::take(5)->get();
        
        if ($tickets->isEmpty()) {
            $tickets = collect([
                (object) ['id' => 1, 'title' => 'Bug Login', 'status' => 'open', 'priority' => 'high'],
                (object) ['id' => 2, 'title' => 'Request Fitur', 'status' => 'in_progress', 'priority' => 'medium'],
            ]);
        }

        $emptyTickets = collect([]);

        return view('demo-blade.includes', compact('tickets', 'emptyTickets'));
    }

    /**
     * Demo Stacks & Push
     */
    public function stacks(): View
    {
        return view('demo-blade.stacks');
    }
}
