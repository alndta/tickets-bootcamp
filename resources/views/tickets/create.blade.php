{{-- ============================================ --}}
{{-- VIEW: tickets/create.blade.php --}}
{{-- Form untuk membuat tiket baru --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Buat Tiket Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Buat Tiket Baru
                </h5>
            </div>
            <div class="card-body">
                {{-- 
                    FORM CREATE dengan CSRF Protection
                    
                    PENTING:
                    1. @csrf WAJIB ada di setiap form POST/PUT/DELETE
                    2. old('field') mengembalikan nilai sebelumnya jika validasi gagal
                    3. @error('field') menampilkan pesan error untuk field tertentu
                --}}
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf

                    {{-- Field: Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Judul Tiket <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Masukkan judul tiket"
                               required
                               maxlength="255">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Maksimal 255 karakter</div>
                    </div>

                    {{-- Field: Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Deskripsi <span class="text-danger">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="5"
                                  placeholder="Jelaskan masalah Anda secara detail..."
                                  required
                                  minlength="10">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">Minimal 10 karakter. Semakin detail semakin baik!</div>
                    </div>

                    {{-- Field: Priority --}}
                    <div class="mb-4">
                        <label for="priority" class="form-label">
                            Prioritas <span class="text-danger">*</span>
                        </label>
                        <select name="priority" 
                                id="priority" 
                                class="form-select @error('priority') is-invalid @enderror"
                                required>
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                🟢 Low - Tidak mendesak
                            </option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                                🟡 Medium - Perlu ditangani
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                🔴 High - Sangat mendesak
                            </option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Simpan Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tips Box --}}
        <div class="card mt-3 border-info">
            <div class="card-body">
                <h6 class="card-title text-info">
                    <i class="bi bi-lightbulb"></i> Tips Membuat Tiket
                </h6>
                <ul class="mb-0 small">
                    <li>Gunakan judul yang jelas dan deskriptif</li>
                    <li>Jelaskan langkah-langkah untuk mereproduksi masalah</li>
                    <li>Sertakan pesan error jika ada</li>
                    <li>Pilih prioritas sesuai urgensi masalah</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
