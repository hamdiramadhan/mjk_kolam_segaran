<?php

use App\Http\Controllers\FaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpdController; 
use App\Http\Controllers\SubOpdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengajuanDetailController;
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
        Route::get('calendar_dashboard', [HomeController::class, 'calendar_dashboard'])->name('calendar_dashboard');
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
            Route::post('pindah_sub_kegiatan', [SubKegiatanController::class, 'pindah_sub_kegiatan'])->name('pindah_sub_kegiatan'); //xxx
            Route::post('sub_kegiatan_rincian_detail', [SubKegiatanController::class, 'sub_kegiatan_rincian_detail'])->name('sub_kegiatan_rincian_detail'); // modal / pop up
            Route::get('sub_kegiatan_rincian_komponen/{id_sub_kegiatan}', [SubKegiatanController::class, 'sub_kegiatan_rincian_komponen'])->name('sub_kegiatan_rincian_komponen'); // page sendiri

            Route::post('add_komponen', [SubKegiatanController::class, 'add_komponen'])->name('add_komponen');
            Route::post('edit_komponen/{id}', [SubKegiatanController::class, 'edit_komponen'])->name('edit_komponen');
            Route::post('update_komponen', [SubKegiatanController::class, 'update_komponen'])->name('update_komponen');
            Route::post('destroy_komponen/{id}', [SubKegiatanController::class, 'destroy_komponen'])->name('destroy_komponen');
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
        // PENGAJUAN PERUBAHAN //
        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');  
        Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::get('/pengajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
        Route::post('/pengajuan/update/{id}', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::get('/pengajuan/detail/{id}', [PengajuanController::class, 'detail'])->name('pengajuan.detail');
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
        //END USULAN //

        // PENGAJUAN PERUBAHAN // 
        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');  
        Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
        // END PENGAJUAN PERUBAHAN //

        //PENGAJUAN DETAIL //
        Route::post('/pengajuan_detail_create', [PengajuanDetailController::class, 'create'])->name('pengajuan_detail_create');
        Route::post('/pengajuan_detail_store/{id}', [PengajuanDetailController::class, 'store'])->name('pengajuan_detail.store');
        Route::get('/pengajuan_detail/komponen/{id}', [PengajuanDetailController::class, 'komponen'])->name('pengajuan_detail.komponen');
        Route::post('/pengajuan_detail_store/{id}', [PengajuanDetailController::class, 'store'])->name('pengajuan_detail.store');
        Route::post('update_detail_komponen/{id}', [PengajuanDetailController::class, 'geser_komponen'])->name('update_detail_komponen');
        Route::post('update_detail_rincian/{id}', [PengajuanDetailController::class, 'update_detail_rincian'])->name('update_detail_rincian');
        Route::post('store_geser_komponen', [PengajuanDetailController::class, 'store_geser_komponen'])->name('store_geser_komponen');
        Route::post('pengajuan_detail/destroy/{id}', [PengajuanDetailController::class,"destroy"])->name('pengajuan_detail.destroy');

        Route::post('update_rincian', [PengajuanDetailController::class, 'update_rincian'])->name('update_rincian');
        Route::post('update_kode_rekening/{id}', [PengajuanDetailController::class, 'update_kode_rekening'])->name('update_kode_rekening');
        Route::post('update_detail_rekening', [PengajuanDetailController::class, 'update_detail_rekening'])->name('update_detail_rekening');
        Route::post('pengajuan/detail_print/{id}', [PengajuanController::class, 'print_detail'])->name('pengajuan.print_detail');
        
        // PENGAJUAN DETAIL

        // START PENGATURAN FASE
            Route::resource('fase', FaseController::class); 
        // END PENGATURAN FASE  
    });
});