{{-- ============================================ --}}
{{-- VIEW: tickets/edit.blade.php --}}
{{-- Form untuk mengedit tiket yang sudah ada --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Edit Tiket #' . $ticket->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Edit Tiket #{{ $ticket->id }}
                </h5>
            </div>
            <div class="card-body">
                {{-- 
                    FORM UPDATE dengan CSRF Protection dan Method Spoofing
                    
                    PENTING:
                    1. @csrf WAJIB ada
                    2. @method('PUT') diperlukan karena HTML form hanya support GET/POST
                       Laravel akan membaca _method hidden field untuk menentukan method sebenarnya
                    3. Nilai default diambil dari $ticket (data existing)
                    4. old('field', $ticket->field) prioritaskan old() jika ada
                --}}
                <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Field: Title --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            Judul Tiket <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $ticket->title) }}"
                               placeholder="Masukkan judul tiket"
                               required
                               maxlength="255">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                                  minlength="10">{{ old('description', $ticket->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Field: Status --}}
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select name="status" 
                                    id="status" 
                                    class="form-select @error('status') is-invalid @enderror"
                                    required>
                                <option value="open" 
                                    {{ old('status', $ticket->status) == 'open' ? 'selected' : '' }}>
                                    🟡 Open
                                </option>
                                <option value="in_progress" 
                                    {{ old('status', $ticket->status) == 'in_progress' ? 'selected' : '' }}>
                                    🔵 In Progress
                                </option>
                                <option value="closed" 
                                    {{ old('status', $ticket->status) == 'closed' ? 'selected' : '' }}>
                                    🟢 Closed
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Field: Priority --}}
                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">
                                Prioritas <span class="text-danger">*</span>
                            </label>
                            <select name="priority" 
                                    id="priority" 
                                    class="form-select @error('priority') is-invalid @enderror"
                                    required>
                                <option value="low" 
                                    {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>
                                    🟢 Low - Tidak mendesak
                                </option>
                                <option value="medium" 
                                    {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>
                                    🟡 Medium - Perlu ditangani
                                </option>
                                <option value="high" 
                                    {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>
                                    🔴 High - Sangat mendesak
                                </option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Ticket Info (Read-only) --}}
                    <div class="mb-4 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Tiket dibuat oleh <strong>{{ $ticket->user->name ?? 'Unknown' }}</strong>
                            pada {{ $ticket->created_at->format('d M Y, H:i') }}
                            <br>
                            Terakhir diupdate: {{ $ticket->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Update Tiket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div class="card mt-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0">
                    <i class="bi bi-exclamation-triangle"></i> Zona Berbahaya
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-3">
                    Aksi di bawah ini tidak dapat dibatalkan. Harap berhati-hati!
                </p>
                <form action="{{ route('tickets.destroy', $ticket) }}" 
                      method="POST"
                      onsubmit="return confirm('PERINGATAN: Tiket akan dihapus permanen!\n\nApakah Anda yakin ingin melanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus Tiket Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
