<?php

use App\Http\Controllers\PengajuanController;
use Illuminate\Support\Facades\Route;

// PENGAJUAN PERUBAHAN //

Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');  
Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
// END PENGAJUAN PERUBAHAN //
?>