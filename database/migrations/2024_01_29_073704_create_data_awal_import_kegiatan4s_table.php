<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAwalImportKegiatan4sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_awal_import_kegiatan4s', function (Blueprint $table) {
            $table->id(); 
            $table->text('sync_kode')->nullable();
            $table->text('nom')->nullable();
            $table->text('tahun')->nullable();
            $table->text('kode_urusan')->nullable();
            $table->text('nama_urusan')->nullable();
            $table->text('kode_skpd')->nullable();
            $table->text('nama_skpd')->nullable();
            $table->text('kode_sub_unit')->nullable();
            $table->text('nama_sub_unit')->nullable();
            $table->text('kode_bidang_urusan')->nullable();
            $table->text('nama_bidang_urusan')->nullable();
            $table->text('kode_program')->nullable();
            $table->text('nama_program')->nullable();
            $table->text('kode_kegiatan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->text('kode_sub_giat')->nullable();
            $table->text('nama_sub_giat')->nullable();
            $table->text('kode_sumber_dana')->nullable();
            $table->text('nama_sumber_dana')->nullable();
            $table->text('kode_rekening')->nullable();
            $table->text('nama_rekening')->nullable();
            $table->text('kode_ssh')->nullable();
            $table->text('nama_ssh')->nullable();
            $table->text('pagu')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_awal_import_kegiatan4s');
    }
}
