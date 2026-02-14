# Hari 5 - Lab Lengkap XSS Prevention

## Deskripsi

Folder ini berisi contoh kode untuk **Hari 5: Lab Lengkap XSS Prevention** dari Bootcamp Secure Coding SMK Wikrama Bogor.

Hari ini kita akan:
1. Mengimplementasikan fitur Comments yang aman di sistem eTicketing
2. Melakukan Security Testing
3. Membuat Security Audit Checklist
4. Menambahkan Security Headers Middleware

## Struktur Folder

```
hari-5-lab-xss/
├── README.md
├── PANDUAN-IMPLEMENTASI.md
├── app/
│   └── Http/
│       ├── Controllers/
│       │   ├── CommentController.php      # Controller untuk comments
│       │   └── SecurityTestController.php # Controller untuk security testing
│       └── Middleware/
│           └── SecurityHeaders.php        # Middleware security headers
├── resources/
│   └── views/
│       ├── partials/
│       │   └── security-popup.blade.php   # Popup security context
│       ├── security-testing/
│       │   ├── index.blade.php            # Dashboard security testing
│       │   ├── xss-test.blade.php         # Test XSS payloads
│       │   ├── csrf-test.blade.php        # Test CSRF protection
│       │   └── headers-test.blade.php     # Test security headers
│       └── tickets/
│           └── show.blade.php             # View ticket dengan comments
└── routes/
    └── web.php                            # Routes untuk hari 5
```

## Prerequisite

1. Selesaikan lab Hari 3 (MVC & CRUD Tickets)
2. Selesaikan lab Hari 4 (Blade & XSS Prevention)
3. Pastikan migration comments sudah dijalankan

## Cara Implementasi

Ikuti panduan di file `PANDUAN-IMPLEMENTASI.md`

## Fitur yang Diimplementasikan

### 1. Sistem Comments pada Tickets
- CRUD comments dengan validasi
- Sanitasi input dengan `strip_tags()`
- Output encoding dengan `{{ }}`
- CSRF protection

### 2. Security Testing Dashboard
- Test XSS payloads
- Test CSRF protection
- Test security headers
- Checklist audit keamanan

### 3. Security Headers Middleware
- Content-Security-Policy
- X-Content-Type-Options
- X-Frame-Options
- X-XSS-Protection

### 4. Security Context Popup
- Modal yang menjelaskan keamanan yang diterapkan
- Bisa ditambahkan ke halaman manapun

## Testing

### XSS Payloads untuk Testing
```html
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
<svg onload=alert('XSS')>
<body onload=alert('XSS')>
<a href="javascript:alert('XSS')">Click</a>
```

### CSRF Testing
Buat file HTML external dan coba submit form ke aplikasi tanpa CSRF token.
Expected: Error 419 (Page Expired)

### Security Headers Testing
```bash
curl -I http://localhost:8000
```

## Catatan Penting

⚠️ **Lab ini HANYA untuk pembelajaran!**
- Jangan gunakan teknik ini untuk menyerang website lain
- Selalu minta izin sebelum melakukan security testing
- Gunakan ilmu ini untuk membangun aplikasi yang lebih aman

## Referensi

- [OWASP XSS Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [Content Security Policy (CSP)](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)
