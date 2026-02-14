<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * SecurityTestController
 * 
 * Controller untuk Security Testing Dashboard
 * HANYA UNTUK DEVELOPMENT - Jangan gunakan di production!
 * 
 * Materi Hari 5 - Lab Lengkap XSS Prevention
 */
class SecurityTestController extends Controller
{
    /**
     * Security Testing Dashboard - Index
     */
    public function index(): View
    {
        return view('security-testing.index');
    }

    /**
     * XSS Testing Page
     * 
     * Halaman untuk menguji berbagai payload XSS
     */
    public function xssTest(Request $request): View
    {
        // Ambil input untuk reflected XSS test
        $testInput = $request->input('test', '');
        
        return view('security-testing.xss-test', [
            'testInput' => $testInput,
        ]);
    }

    /**
     * CSRF Testing Page
     * 
     * Halaman untuk demonstrasi CSRF protection
     */
    public function csrfTest(): View
    {
        return view('security-testing.csrf-test');
    }

    /**
     * CSRF Test POST Handler
     * 
     * Endpoint untuk test CSRF protection
     */
    public function csrfTestPost(Request $request)
    {
        $validated = $request->validate([
            'test_data' => 'required|string|max:255',
        ]);

        return redirect()->route('security-testing.csrf')
            ->with('success', 'Form berhasil disubmit! CSRF token valid.')
            ->with('submitted_data', $validated['test_data']);
    }

    /**
     * Security Headers Testing Page
     * 
     * Halaman untuk melihat security headers
     */
    public function headersTest(): View
    {
        // Ambil semua headers yang akan dikirim
        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net;",
        ];
        
        return view('security-testing.headers-test', [
            'expectedHeaders' => $headers,
        ]);
    }

    /**
     * Security Audit Checklist
     */
    public function auditChecklist(): View
    {
        $checklist = [
            'xss' => [
                'title' => 'XSS Prevention',
                'items' => [
                    'Semua user input di-escape dengan {{ }}',
                    '{!! !!} hanya untuk trusted content',
                    'JavaScript data menggunakan @json()',
                    'strip_tags() digunakan untuk sanitasi',
                    'HTML Purifier untuk rich text (jika ada)',
                ],
            ],
            'csrf' => [
                'title' => 'CSRF Protection',
                'items' => [
                    '@csrf ada di setiap form',
                    'VerifyCsrfToken middleware aktif',
                    'API routes menggunakan token atau Sanctum',
                ],
            ],
            'input' => [
                'title' => 'Input Validation',
                'items' => [
                    'Semua input divalidasi di server',
                    'Validation rules yang spesifik',
                    'Error messages yang informatif',
                    'File upload validation (jika ada)',
                ],
            ],
            'headers' => [
                'title' => 'Security Headers',
                'items' => [
                    'Content-Security-Policy',
                    'X-Content-Type-Options: nosniff',
                    'X-Frame-Options: SAMEORIGIN',
                    'X-XSS-Protection: 1; mode=block',
                    'Strict-Transport-Security (HTTPS)',
                ],
            ],
            'auth' => [
                'title' => 'Authentication & Authorization',
                'items' => [
                    'Routes dilindungi middleware auth',
                    'Authorization check sebelum aksi sensitif',
                    'Password hashing dengan bcrypt/argon2',
                    'Session timeout dikonfigurasi',
                    'Rate limiting untuk login',
                ],
            ],
        ];

        return view('security-testing.audit-checklist', [
            'checklist' => $checklist,
        ]);
    }
}
