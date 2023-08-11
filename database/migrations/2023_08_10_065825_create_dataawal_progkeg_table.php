<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataawalProgkegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        INSERT INTO public.dataawal_progkeg(nama_urusan, nama_opd, nama_sub_opd, nama_program, nama_kegiatan, nama_sub_kegiatan, nama_rekening, total) VALUES ('"&&"','"&&"','"&&"','"&&"','"&&"','"&&"','"&&"','"&&"');
        */
        Schema::create('dataawal_progkeg', function (Blueprint $table) {
            $table->id();
            $table->text('kode_urusan')->nullable();
            $table->text('nama_urusan')->nullable();
            $table->text('kode_opd')->nullable();
            $table->text('nama_opd')->nullable();
            $table->text('kode_sub_opd')->nullable();
            $table->text('nama_sub_opd')->nullable();
            $table->text('kode_program')->nullable();
            $table->text('nama_program')->nullable();
            $table->text('kode_kegiatan')->nullable();
            $table->text('nama_kegiatan')->nullable();
            $table->text('kode_sub_kegiatan')->nullable();
            $table->text('nama_sub_kegiatan')->nullable();
            $table->text('kode_rekening')->nullable();
            $table->text('nama_rekening')->nullable();
            $table->double('total')->nullable();
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
        Schema::dropIfExists('dataawal_progkeg');
    }
}
