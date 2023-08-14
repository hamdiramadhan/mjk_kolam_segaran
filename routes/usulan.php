<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

// PENGAJUAN PERUBAHAN //
Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');  
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
Route::get('/pengajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
Route::post('/pengajuan/update/{id}', [PengajuanController::class, 'update'])->name('pengajuan.update');
Route::post('/pengajuan/destroy/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
Route::get('/pengajuan/proses', [PengajuanController::class, 'proses'])->name('pengajuan.proses');
Route::get('/pengajuan/selesai', [PengajuanController::class, 'selesai'])->name('pengajuan.selesai');
Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::post('/pengajuan/print/{id}', [PengajuanController::class, 'print_pengajuan'])->name('pengajuan.print');
Route::post('/pengajuan/send/{id}', [PengajuanController::class, 'send'])->name('pengajuan.send');
Route::post('/pengajuan/verif/{id}', [PengajuanController::class, 'verif'])->name('pengajuan.verif');
// END PENGAJUAN PERUBAHAN //

// PENGAJUAN PERUBAHAN VERIFIKATOR //
Route::get('/pengajuan/masuk', [PengajuanController::class, 'proses'])->name('pengajuan.masuk');
Route::get('/pengajuan/selesai_verif', [PengajuanController::class, 'selesai'])->name('pengajuan.selesai_verif');
// END PENGAJUAN PERUBAHAN VERIFIKATOR //
?>