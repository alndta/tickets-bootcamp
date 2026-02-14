<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 * 
 * Middleware untuk menambahkan security headers ke setiap response
 * 
 * Materi Hari 5 - Lab Lengkap XSS Prevention
 * 
 * Headers yang ditambahkan:
 * 1. X-Content-Type-Options: Mencegah MIME type sniffing
 * 2. X-Frame-Options: Mencegah clickjacking
 * 3. X-XSS-Protection: Mengaktifkan XSS filter browser
 * 4. Referrer-Policy: Mengontrol referrer header
 * 5. Content-Security-Policy: Mengontrol sumber daya yang boleh dimuat
 * 6. Permissions-Policy: Mengontrol fitur browser yang diizinkan
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // =============================================
        // X-Content-Type-Options
        // =============================================
        // Mencegah browser melakukan MIME type sniffing
        // Browser akan selalu mengikuti Content-Type yang diberikan server
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // =============================================
        // X-Frame-Options
        // =============================================
        // Mencegah halaman dimuat dalam iframe (clickjacking protection)
        // Options:
        // - DENY: Tidak boleh sama sekali
        // - SAMEORIGIN: Hanya boleh dari domain yang sama
        // - ALLOW-FROM uri: Hanya boleh dari URI tertentu (deprecated)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // =============================================
        // X-XSS-Protection
        // =============================================
        // Mengaktifkan XSS filter bawaan browser
        // Note: Sudah deprecated di browser modern, tapi masih berguna untuk browser lama
        // Options:
        // - 0: Nonaktifkan filter
        // - 1: Aktifkan filter
        // - 1; mode=block: Aktifkan dan block halaman jika terdeteksi XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // =============================================
        // Referrer-Policy
        // =============================================
        // Mengontrol informasi referrer yang dikirim
        // strict-origin-when-cross-origin:
        // - Same-origin: kirim full URL
        // - Cross-origin HTTPS→HTTPS: kirim origin saja
        // - Cross-origin HTTPS→HTTP: tidak kirim apa-apa
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // =============================================
        // Content-Security-Policy (CSP)
        // =============================================
        // Mengontrol sumber daya apa saja yang boleh dimuat browser
        // 
        // PENTING: Sesuaikan dengan kebutuhan aplikasi Anda!
        // CSP yang terlalu ketat bisa membreak functionality
        // 
        // Directives:
        // - default-src: Fallback untuk semua resource types
        // - script-src: JavaScript sources
        // - style-src: CSS sources
        // - img-src: Image sources
        // - font-src: Font sources
        // - connect-src: AJAX, WebSocket, dll
        // - frame-ancestors: Siapa yang boleh embed halaman ini
        $csp = implode('; ', [
            "default-src 'self'",
            // Script sources
            // 'unsafe-inline' dan 'unsafe-eval' diperlukan untuk beberapa library
            // Idealnya gunakan nonce atau hash untuk inline scripts
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com",
            // Style sources
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.googleapis.com",
            // Image sources
            "img-src 'self' data: https: blob:",
            // Font sources
            "font-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://fonts.gstatic.com",
            // Connect sources (AJAX, fetch, WebSocket)
            "connect-src 'self'",
            // Frame ancestors (who can embed this page)
            "frame-ancestors 'self'",
            // Form action (where forms can submit to)
            "form-action 'self'",
            // Base URI
            "base-uri 'self'",
        ]);
        $response->headers->set('Content-Security-Policy', $csp);

        // =============================================
        // Permissions-Policy (formerly Feature-Policy)
        // =============================================
        // Mengontrol fitur browser yang diizinkan
        // Mencegah abuse fitur sensitif seperti camera, microphone, dll
        $permissions = implode(', ', [
            'camera=()',           // Disable camera
            'microphone=()',       // Disable microphone
            'geolocation=()',      // Disable geolocation
            'payment=()',          // Disable payment API
            'usb=()',              // Disable USB API
            'interest-cohort=()',  // Disable FLoC (privacy)
        ]);
        $response->headers->set('Permissions-Policy', $permissions);

        // =============================================
        // Strict-Transport-Security (HSTS)
        // =============================================
        // Memaksa browser selalu menggunakan HTTPS
        // HANYA AKTIFKAN JIKA SUDAH MENGGUNAKAN HTTPS!
        // 
        // Uncomment baris di bawah jika production dengan HTTPS:
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        return $response;
    }
}
