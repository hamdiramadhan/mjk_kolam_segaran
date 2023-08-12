<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpdController; 
use App\Http\Controllers\SubOpdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SubKegiatanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => ['XSS']], function () {
    /* START PUBLIC */

    Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);
    Route::group(['middleware' => 'auth'], function () {
        // DASHBOARD //
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::post('change_tahun_app_login', [HomeController::class, "change_tahun_app_login"])->name('change_tahun_app_login');
        // END DSAHBOARD// 

        // SUB KEGIATAN
            Route::get('dataawal_progkeg', [SubKegiatanController::class, 'dataawal_progkeg'])->name('dataawal_progkeg');  
            Route::get('dataawal_progkeg_syncopd', [SubKegiatanController::class, 'dataawal_progkeg_syncopd'])->name('dataawal_progkeg_syncopd');  
            Route::get('dataawal_progkeg_programkegiatan', [SubKegiatanController::class, 'dataawal_progkeg_programkegiatan'])->name('dataawal_progkeg_programkegiatan');  
            
            Route::get('sub_kegiatan', [SubKegiatanController::class, 'index'])->name('sub_kegiatan');  
            Route::get('create/sub_kegiatan',[SubKegiatanController::class, 'create'])->name('create_sub_kegiatan');
            Route::get('edit/sub_kegiatan/{id}',[SubKegiatanController::class, 'edit'])->name('edit_sub_kegiatan');
            Route::post('edit/sub_kegiatan/save/{id}',[SubKegiatanController::class, 'update'])->name('simpan_ubah_sub_kegiatan');
            Route::post('create/sub_kegiatan/save',[SubKegiatanController::class, 'store'])->name('simpan_tambah_sub_kegiatan');
            Route::post('sub_kegiatan-import', [SubKegiatanController::class, 'import'])->name('sub_kegiatan.import');
            Route::post('sub_kegiatan-ajax', [SubKegiatanController::class, 'ajax'])->name('sub_kegiatan.ajax');
        // SUB KEGIATAN

        // RINCIAN
            Route::get('sub_kegiatan_rincian',[SubKegiatanController::class, 'sub_kegiatan_rincian'])->name('sub_kegiatan_rincian');
            Route::post('pindah_sub_kegiatan', [PekerjaanController::class, 'pindah_sub_kegiatan'])->name('pindah_sub_kegiatan');
        // RINCIAN

        // START MASTER OPD
            Route::get('/master_opd', [OpdController::class, 'index'])->name('master_opd');
            Route::get('create/master_opd',[OpdController::class, 'create'])->name('create_master_opd');
            Route::post('create/master_opd/save',[OpdController::class, 'store'])->name('simpan_tambah_opd');
            Route::get('edit/master_opd/{id}',[OpdController::class, 'edit'])->name('edit_master_opd');
            Route::post('edit/master_opd/save/{id}',[OpdController::class, 'update'])->name('simpan_ubah_opd');
            Route::post('master_opd/destroy/{id}', [OpdController::class,"destroy"]);
            Route::post('opd_aktif_usul', [OpdController::class,"opd_aktif_usul"])->name('opd_aktif_usul'); 
            Route::post('aktif_usulan', [OpdController::class,"aktif_usulan"])->name('aktif_usulan'); 
        // END MASTER OPD

        // START MASTER SUB OPD
            Route::get('/master_sub_opd', [SubOpdController::class, 'index'])->name('master_sub_opd');
            Route::get('create/master_sub_opd',[SubOpdController::class, 'create'])->name('create_master_sub_opd');
            Route::post('create/master_sub_opd/save',[SubOpdController::class, 'store'])->name('simpan_tambah_sub_opd');
            Route::get('edit/master_sub_opd/{id}',[SubOpdController::class, 'edit'])->name('edit_master_sub_opd');
            Route::post('edit/master_sub_opd/save/{id}',[SubOpdController::class, 'update'])->name('simpan_ubah_sub_opd');
            Route::post('master_sub_opd/destroy/{id}', [SubOpdController::class,"destroy"]);
        // END MASTER SUB OPD  
        
        //MASTER //
        include 'master.php';
        //END MASTER //

        //USULAN //
        include 'usulan.php';
        //END USULAN //

        // PENGAJUAN PERUBAHAN //

        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');  
        Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
        // END PENGAJUAN PERUBAHAN //
    });
});