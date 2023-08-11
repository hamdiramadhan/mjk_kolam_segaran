<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            $table->text('unit_id')->nullable();
            $table->text('unit_name')->nullable();
            $table->text('kepala_nama')->nullable();
            $table->text('kepala_nip')->nullable();
            $table->text('kepala_pangkat')->nullable();
            $table->integer('max_operator')->nullable()->default('0');
            $table->text('alamat')->nullable();
            $table->text('telp')->nullable();
            $table->text('fax')->nullable();
            $table->integer('induk')->nullable();
            $table->string('unit_id_sidirga')->nullable();
            $table->integer('jenis_instansi')->nullable();
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
        Schema::dropIfExists('opds');
    }
}