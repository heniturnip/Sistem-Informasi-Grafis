<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;
use App\Models\Facility;

Route::get('/', [FacilityController::class, 'index']);

Route::get('/home', [FacilityController::class, 'showHome'])->name('home'); // Route untuk halaman utama
Route::get('/facility/{id}', [FacilityController::class, 'show'])->name('facility.show'); // Route untuk halaman detail fasilitas

Route::get('/facility/{id}', function($id) {
    $facility = Facility::findOrFail($id);  // Mengambil data fasilitas berdasarkan ID
    // Mengecek tipe fasilitas untuk menampilkan halaman yang sesuai
    if ($facility->type == 'pasar') {
        return view('detail.pasar', compact('facility'));  // Untuk pasar
    } elseif ($facility->type == 'rumah sakit') {
        return view('detail.rumah_sakit', compact('facility'));  // Untuk rumah sakit
    }
});

Route::get('/home', function () {
    return view('home'); // Mengarah ke home.blade.php
})->name('home');

