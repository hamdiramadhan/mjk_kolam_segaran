<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekenings', function (Blueprint $table) {
            $table->id();
            $table->integer('opd_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->integer('master_sub_kegiatan_id')->nullable();
            $table->string('kode_sub_kegiatan')->nullable(); 
            $table->string('kode_rekening')->nullable(); 
            $table->string('nama_rekening')->nullable();  

            $table->double('harga')->nullable(); 
            $table->double('harga_perubahan')->nullable(); 

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
        Schema::dropIfExists('rekenings');
    }
}
