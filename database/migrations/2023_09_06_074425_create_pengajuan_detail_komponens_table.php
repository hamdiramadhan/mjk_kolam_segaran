<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanDetailKomponensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_detail_komponens', function (Blueprint $table) {
            $table->id();
            $table->integer('pengajuan_id')->nullable();
            $table->integer('pengajuan_detail_id')->nullable();
            $table->integer('opd_id')->nullable();
            $table->integer('master_sub_kegiatan_id')->nullable();
            $table->string('kode_sub_kegiatan_id')->nullable();
            $table->integer('rekenings_id')->nullable();
            $table->string('kode_rekening')->nullable();
            $table->text('spek')->nullable();
            $table->text('detail')->nullable();
            $table->text('satuan')->nullable();
            $table->double('volume')->nullable();
            $table->text('koefisien')->nullable();
            $table->double('harga')->nullable();
            $table->double('ppn')->nullable();

            $table->integer('rekenings_id_pergeseran')->nullable();
            $table->string('kode_rekening_pergeseran')->nullable();
            $table->text('spek_pergeseran')->nullable();
            $table->text('detail_pergeseran')->nullable();
            $table->text('satuan_pergeseran')->nullable();
            $table->double('volume_pergeseran')->nullable();
            $table->text('koefisien_pergeseran')->nullable();
            $table->double('harga_pergeseran')->nullable();
            $table->double('ppn_pergeseran')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('pengajuan_detail_komponens');
    }
}