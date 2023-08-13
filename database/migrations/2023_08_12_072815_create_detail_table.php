<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail', function (Blueprint $table) {
            $table->id(); 
            $table->integer('opd_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->integer('master_sub_kegiatan_id')->nullable();
            $table->string('kode_sub_kegiatan')->nullable();
            $table->integer('rekenings_id')->nullable();
            $table->string('kode_rekening')->nullable(); 
            $table->string('nama_rekening')->nullable(); 
            $table->string('kode_detail')->nullable();
            $table->string('detail')->nullable();
            $table->string('merk')->nullable();
            $table->string('spek')->nullable();

            $table->double('volume')->nullable();
            $table->string('koefisien')->nullable();
            $table->double('harga')->nullable();
            $table->double('ppn')->nullable();
            $table->double('volume_perubahan')->nullable();
            $table->string('koefisien_perubahan')->nullable();
            $table->double('harga_perubahan')->nullable();
            $table->double('ppn_perubahan')->nullable();
            
            $table->string('satuan')->nullable(); 
            $table->string('subtitle')->nullable(); 
            $table->string('subtitle2')->nullable(); 
            $table->integer('tahun')->nullable();
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
        Schema::dropIfExists('detail');
    }
}
