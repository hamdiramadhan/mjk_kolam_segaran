<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSubKegiatanImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sub_kegiatan_import', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun')->nullable();
            $table->integer('opd_id')->nullable();
            $table->string('kode1')->nullable();
            $table->string('kode2')->nullable();
            $table->string('kode3')->nullable();
            $table->string('kode4')->nullable();
            $table->string('kode5')->nullable();
            $table->text('uraian')->nullable();
            $table->string('kodedinas')->nullable();
            $table->text('namadinas')->nullable(); 
            $table->text('sync_kode')->nullable(); 
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
        Schema::dropIfExists('master_sub_kegiatan_import');
    }
}
