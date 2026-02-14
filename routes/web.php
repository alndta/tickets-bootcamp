<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes - Contoh untuk Hari 3 MVC Laravel
|--------------------------------------------------------------------------
|
| Tambahkan route di bawah ini ke file routes/web.php di proyek Laravel Anda
|
*/

// ============================================
// BASIC ROUTES (Contoh)
// ============================================

Route::get('/', function () {
    return view('welcome');
});

// Route sederhana dengan Closure
Route::get('/hello', function () {
    return 'Hello World! Selamat datang di Bootcamp Secure Coding!';
});

// Route yang mengembalikan JSON
Route::get('/api/status', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'Server berjalan dengan baik',
        'time' => now()->toDateTimeString(),
    ]);
});

// ============================================
// RESOURCE ROUTES - TICKETS
// ============================================

// Route::resource() otomatis membuat 7 routes:
// GET    /tickets           → TicketController@index    (tickets.index)
// GET    /tickets/create    → TicketController@create   (tickets.create)
// POST   /tickets           → TicketController@store    (tickets.store)
// GET    /tickets/{ticket}  → TicketController@show     (tickets.show)
// GET    /tickets/{ticket}/edit → TicketController@edit (tickets.edit)
// PUT    /tickets/{ticket}  → TicketController@update   (tickets.update)
// DELETE /tickets/{ticket}  → TicketController@destroy  (tickets.destroy)

Route::resource('tickets', TicketController::class);

// ============================================
// ALTERNATIVE: ROUTES MANUAL
// ============================================
// Jika ingin mendefinisikan secara manual:
// 
// Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
// Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
// Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
// Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
// Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
// Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
// Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
