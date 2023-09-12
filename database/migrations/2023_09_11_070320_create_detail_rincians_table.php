<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRinciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_rincians', function (Blueprint $table) {
            $table->id();
            $table->integer('pengajuan_id')->nullable();
            $table->integer('detail_id')->nullable();
            $table->integer('opd_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->integer('master_sub_kegiatan_id')->nullable();
            $table->string('kode_sub_kegiatan')->nullable();
            $table->integer('rekenings_id')->nullable();
            $table->string('kode_rekening_pergeseran')->nullable(); 
            $table->string('nama_rekening_pergeseran')->nullable(); 
            $table->string('kode_detail_pergeseran')->nullable();
            $table->string('detail_pergeseran')->nullable();
            $table->string('merk_pergeseran')->nullable();
            $table->string('spek_pergeseran')->nullable();
            $table->double('volume_pergeseran')->nullable();
            $table->string('koefisien_pergeseran')->nullable();
            $table->double('harga_pergeseran')->nullable();
            $table->double('ppn_pergeseran')->nullable();
            $table->string('satuan_pergeseran')->nullable(); 
            $table->string('subtitle_pergeseran')->nullable(); 
            $table->string('subtitle2_pergeseran')->nullable(); 
            $table->integer('tahun_pergeseran')->nullable();
            $table->string('sync_kode')->nullable();
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
        Schema::dropIfExists('detail_rincians');
    }
}