<?php

use App\Http\Controllers\JenisUsulanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// MASTER USER //
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::post('users/destroy/{id}', [UserController::class,"destroy"])->name('users.destroy');

// END MASTER USER //


// MASTER JENIS USULAN //
Route::get('/usulan', [JenisUsulanController::class, 'index'])->name('jenis_usulan.index');
Route::get('/jenis_usulan/create', [JenisUsulanController::class, 'create'])->name('jenis_usulan.create');
Route::post('/jenis_usulan/store', [JenisUsulanController::class, 'store'])->name('jenis_usulan.store');
Route::get('/jenis_usulan/edit/{id}', [JenisUsulanController::class, 'edit'])->name('jenis_usulan.edit');
Route::post('/jenis_usulan/update/{id}', [JenisUsulanController::class, 'update'])->name('jenis_usulan.update');
Route::post('jenis_usulan/destroy/{id}', [JenisUsulanController::class,"destroy"])->name('jenis_usulan.destroy');

// END MASTER JENIS USULAN //
?>