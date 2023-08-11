<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->integer('opd_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('sifat_surat')->nullable();
            $table->string('lampiran')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('status')->nullable();
            $table->integer('usulan_id')->nullable();
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
        Schema::dropIfExists('pengajuans');
    }
}