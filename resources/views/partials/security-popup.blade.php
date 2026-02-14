{{-- ============================================ --}}
{{-- SECURITY CONTEXT POPUP --}}
{{-- Modal yang menjelaskan konsep keamanan --}}
{{-- 
{{-- Materi Hari 5 - Lab Lengkap XSS Prevention --}}
{{-- ============================================ --}}

{{-- Security Modal --}}
<div class="modal fade" id="securityModal" tabindex="-1" aria-labelledby="securityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="securityModalLabel">
                    <i class="bi bi-shield-lock"></i> Security Context
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- XSS Prevention --}}
                <div class="mb-4">
                    <h6 class="text-primary">
                        <i class="bi bi-shield-exclamation"></i> XSS Prevention yang Diterapkan
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Layer</th>
                                    <th>Teknik</th>
                                    <th>Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Input Validation</td>
                                    <td><code>$request->validate()</code></td>
                                    <td>Memastikan input sesuai aturan (required, min, max)</td>
                                </tr>
                                <tr>
                                    <td>Sanitization</td>
                                    <td><code>strip_tags()</code></td>
                                    <td>Menghapus semua HTML tags dari input</td>
                                </tr>
                                <tr>
                                    <td>Output Encoding</td>
                                    <td><code>@{{ }}</code></td>
                                    <td>Auto-escape semua output (htmlspecialchars)</td>
                                </tr>
                                <tr>
                                    <td>CSRF Token</td>
                                    <td><code>@@csrf</code></td>
                                    <td>Mencegah Cross-Site Request Forgery</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Defense in Depth --}}
                <div class="mb-4">
                    <h6 class="text-success">
                        <i class="bi bi-layers"></i> Defense in Depth
                    </h6>
                    <p class="small text-muted">
                        Kami menggunakan multiple layers of protection. Jika satu layer gagal, 
                        layer lainnya masih melindungi aplikasi.
                    </p>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center">
                                    <i class="bi bi-1-circle text-success display-6"></i>
                                    <p class="small mb-0 mt-2">
                                        <strong>Validation</strong><br>
                                        Cek format input
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-warning">
                                <div class="card-body text-center">
                                    <i class="bi bi-2-circle text-warning display-6"></i>
                                    <p class="small mb-0 mt-2">
                                        <strong>Sanitization</strong><br>
                                        Bersihkan input
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center">
                                    <i class="bi bi-3-circle text-primary display-6"></i>
                                    <p class="small mb-0 mt-2">
                                        <strong>Output Encoding</strong><br>
                                        Escape output
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Test XSS --}}
                <div class="mb-4">
                    <h6 class="text-danger">
                        <i class="bi bi-bug"></i> Coba Test (Tidak Akan Berhasil)
                    </h6>
                    <p class="small text-muted">
                        Copy payload di bawah dan paste ke form komentar:
                    </p>
                    <div class="bg-dark text-white p-2 rounded mb-2">
                        <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                        <button class="btn btn-sm btn-outline-light float-end" 
                                onclick="navigator.clipboard.writeText('<script>alert(\'XSS\')</script>')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="bg-dark text-white p-2 rounded mb-2">
                        <code>&lt;img src=x onerror=alert('XSS')&gt;</code>
                        <button class="btn btn-sm btn-outline-light float-end" 
                                onclick="navigator.clipboard.writeText('<img src=x onerror=alert(\'XSS\')>')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle"></i>
                        Input akan ditampilkan sebagai teks biasa, <strong>bukan</strong> dieksekusi sebagai script.
                    </div>
                </div>

                {{-- Code Examples --}}
                <div class="mb-4">
                    <h6 class="text-info">
                        <i class="bi bi-code-slash"></i> Contoh Kode
                    </h6>
                    
                    <p class="small text-muted">Controller (Sanitization):</p>
                    <pre class="bg-light p-2 rounded small"><code>// Hapus HTML tags
$cleanContent = strip_tags($validated['content']);</code></pre>
                    
                    <p class="small text-muted mt-3">View (Output Encoding):</p>
                    <pre class="bg-light p-2 rounded small"><code>{{-- Safe: Auto-escaped --}}
@{{ $comment->content }}

{{-- Safe: nl2br + e() --}}
@{!! nl2br(e($comment->content)) !!}</code></pre>
                </div>

                {{-- Security Headers --}}
                <div>
                    <h6 class="text-secondary">
                        <i class="bi bi-server"></i> Security Headers
                    </h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>X-Content-Type-Options</span>
                            <code>nosniff</code>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>X-Frame-Options</span>
                            <code>SAMEORIGIN</code>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>X-XSS-Protection</span>
                            <code>1; mode=block</code>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span>Content-Security-Policy</span>
                            <code>default-src 'self'; ...</code>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('xss-lab.index') }}" class="btn btn-outline-danger">
                    <i class="bi bi-shield-exclamation"></i> Lihat XSS Lab
                </a>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="bi bi-check"></i> Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Floating Button untuk trigger modal --}}
<style>
    .security-floating-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
</style>
<button type="button" 
        class="btn btn-info btn-lg rounded-circle security-floating-btn" 
        data-bs-toggle="modal" 
        data-bs-target="#securityModal"
        title="Lihat Security Context">
    <i class="bi bi-shield-lock"></i>
</button>
