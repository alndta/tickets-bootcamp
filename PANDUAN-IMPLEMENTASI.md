# Panduan Implementasi - Hari 5: Lab Lengkap XSS Prevention

## Daftar Isi

1. [Overview](#overview)
2. [Perbedaan dengan Hari 4](#perbedaan-dengan-hari-4)
3. [Step 1: CommentController](#step-1-commentcontroller)
4. [Step 2: Security Headers Middleware](#step-2-security-headers-middleware)
5. [Step 3: Update Ticket Show View](#step-3-update-ticket-show-view)
6. [Step 4: Security Context Popup](#step-4-security-context-popup)
7. [Step 5: Security Testing Dashboard](#step-5-security-testing-dashboard)
8. [Step 6: Routes](#step-6-routes)
9. [Step 7: Register Middleware](#step-7-register-middleware)
10. [Testing](#testing)

---

## Overview

Hari ini kita akan melengkapi fitur Comments pada sistem eTicketing dan membuat dashboard untuk Security Testing. Fokus utama adalah penerapan XSS prevention yang sudah dipelajari di hari sebelumnya ke dalam fitur nyata.

---

## ⚠️ Perbedaan dengan Hari 4

**PENTING:** Ada **2 tabel comments terpisah** di bootcamp ini:

| Aspek | Hari 4: XSS Lab | Hari 5: Ticket Comments |
|-------|-----------------|-------------------------|
| **Tabel** | `xss_lab_comments` | `comments` |
| **Model** | `XssLabComment` | `Comment` |
| **Tujuan** | Demo XSS (vulnerable & secure) | Fitur real ticket comments |
| **Auth** | ❌ Tidak (pakai `author_name`) | ✅ Ya (pakai `user_id`) |
| **Bisa di-reset?** | ✅ Ya, untuk demo ulang | ❌ Tidak, data real |

**Mengapa dipisah?**
1. XSS Lab tidak memerlukan authentication (untuk demo mudah)
2. XSS Lab bisa di-reset kapan saja tanpa mempengaruhi data real
3. Struktur berbeda: `author_name` (guest) vs `user_id` (authenticated)

---

## Step 1: CommentController

Copy file `app/Http/Controllers/CommentController.php` ke project Anda.

### Penjelasan Keamanan:

```php
// ✅ VALIDASI INPUT
$validated = $request->validate([
    'content' => 'required|string|min:3|max:2000',
]);

// ✅ SANITASI: strip_tags untuk hapus HTML
$cleanContent = strip_tags($validated['content']);
```

**Mengapa ini penting?**
- `validate()` memastikan input sesuai format yang diharapkan
- `strip_tags()` menghapus semua HTML tags dari input
- Ini adalah defense in depth - multiple layers of protection

---

## Step 2: Security Headers Middleware

Copy file `app/Http/Middleware/SecurityHeaders.php` ke project Anda.

### Headers yang ditambahkan:

| Header | Nilai | Fungsi |
|--------|-------|--------|
| X-Content-Type-Options | nosniff | Mencegah MIME type sniffing |
| X-Frame-Options | SAMEORIGIN | Mencegah clickjacking |
| X-XSS-Protection | 1; mode=block | Aktifkan XSS filter browser |
| Referrer-Policy | strict-origin-when-cross-origin | Kontrol referrer header |
| Content-Security-Policy | ... | Kontrol sumber daya yang boleh dimuat |

### Register Middleware:

Untuk Laravel 11+, tambahkan di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\SecurityHeaders::class,
    ]);
})
```

Untuk Laravel 10 dan sebelumnya, di `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // ... middleware lainnya
        \App\Http\Middleware\SecurityHeaders::class,
    ],
];
```

---

## Step 3: Update Ticket Show View

Copy file `resources/views/tickets/show.blade.php`.

### Security Features di View:

1. **CSRF Token**: `@csrf` di setiap form
2. **Auto-escape**: Semua output menggunakan `{{ }}`
3. **Method Spoofing**: `@method('DELETE')` untuk form delete
4. **Confirm Dialog**: JavaScript confirmation sebelum delete

```blade
{{-- ✅ SAFE: Auto-escaped --}}
<p>{{ $ticket->description }}</p>

{{-- ✅ Preserve line breaks dengan aman --}}
<p>{!! nl2br(e($comment->content)) !!}</p>
```

---

## Step 4: Security Context Popup

Copy file `resources/views/partials/security-popup.blade.php`.

### Cara Menggunakan:

1. Include di view yang diinginkan:
```blade
@include('partials.security-popup')
```

2. Pastikan Bootstrap 5 sudah di-load

3. Trigger button akan muncul floating di kanan bawah

---

## Step 5: Security Testing Dashboard

Copy semua file di folder `resources/views/security-testing/`.

Dashboard ini menyediakan:
- **XSS Test**: Testing berbagai payload XSS
- **CSRF Test**: Demonstrasi CSRF protection
- **Headers Test**: Cek security headers
- **Audit Checklist**: Checklist keamanan aplikasi

---

## Step 6: Routes

Tambahkan routes berikut ke `routes/web.php`:

```php
// Comments routes
Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');

// Security Testing routes (hanya untuk development!)
Route::prefix('security-testing')->name('security-testing.')->group(function () {
    Route::get('/', [SecurityTestController::class, 'index'])->name('index');
    Route::get('/xss', [SecurityTestController::class, 'xssTest'])->name('xss');
    Route::get('/csrf', [SecurityTestController::class, 'csrfTest'])->name('csrf');
    Route::post('/csrf', [SecurityTestController::class, 'csrfTestPost'])->name('csrf.post');
    Route::get('/headers', [SecurityTestController::class, 'headersTest'])->name('headers');
});
```

---

## Step 7: Register Middleware

### Laravel 11+

Edit `bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

### Laravel 10 dan sebelumnya

Edit `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \App\Http\Middleware\SecurityHeaders::class, // <-- Tambahkan ini
    ],
    // ...
];
```

---

## Testing

### 1. Test Comments Feature

```bash
# Buka halaman ticket
http://localhost:8000/tickets/1

# Coba submit comment dengan XSS payload
<script>alert('XSS')</script>

# Payload harus ditampilkan sebagai teks biasa
```

### 2. Test Security Headers

```bash
# Menggunakan curl
curl -I http://localhost:8000

# Atau buka DevTools > Network > Headers
```

Expected output:
```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Content-Security-Policy: default-src 'self'; ...
```

### 3. Test CSRF Protection

Buat file `test-csrf.html`:

```html
<!DOCTYPE html>
<html>
<head><title>CSRF Test</title></head>
<body>
    <h1>CSRF Attack Test</h1>
    <form action="http://localhost:8000/tickets/1/comments" method="POST">
        <input name="content" value="Spam from external site">
        <button type="submit">Submit tanpa CSRF Token</button>
    </form>
</body>
</html>
```

Buka file ini di browser dan submit. Expected: **419 Page Expired**

### 4. Security Testing Dashboard

```bash
http://localhost:8000/security-testing
```

Gunakan dashboard untuk:
- Test berbagai XSS payloads
- Verify CSRF protection
- Check security headers
- Complete audit checklist

---

## Security Audit Checklist

Sebelum menyelesaikan hari ini, pastikan:

### XSS Prevention
- [ ] Semua user input di-escape dengan `{{ }}`
- [ ] `{!! !!}` hanya untuk trusted content
- [ ] JavaScript data menggunakan `@json()`
- [ ] `strip_tags()` digunakan untuk sanitasi input

### CSRF Protection
- [ ] `@csrf` ada di setiap form
- [ ] VerifyCsrfToken middleware aktif

### Input Validation
- [ ] Semua input divalidasi di server
- [ ] Validation rules yang spesifik (min, max, string, etc.)

### Security Headers
- [ ] SecurityHeaders middleware aktif
- [ ] CSP policy dikonfigurasi

### Authentication & Authorization
- [ ] Routes dilindungi middleware auth
- [ ] Authorization check (owner only delete)

---

## Troubleshooting

### Form tidak bisa submit

**Problem**: Error 419 Page Expired

**Solution**: Pastikan `@csrf` ada di dalam form

### Comment tidak tersimpan

**Problem**: Validation error

**Solution**: Cek validation rules dan pastikan input memenuhi syarat

### Security headers tidak muncul

**Problem**: Headers tidak ada di response

**Solution**: 
1. Pastikan middleware terdaftar
2. Clear cache: `php artisan config:clear`
3. Restart server: `php artisan serve`

### Modal tidak muncul

**Problem**: Security context popup tidak tampil

**Solution**: Pastikan Bootstrap 5 JS sudah di-load

---

## Kesimpulan

Setelah menyelesaikan hari ini, Anda telah:

1. ✅ Mengimplementasikan fitur Comments yang aman
2. ✅ Menambahkan Security Headers
3. ✅ Membuat Security Testing Dashboard
4. ✅ Melakukan audit keamanan aplikasi

**Next Step**: Minggu 3 - SQL Injection & Authentication
