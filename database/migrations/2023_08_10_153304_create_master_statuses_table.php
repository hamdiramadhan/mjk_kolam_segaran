<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('kode')->default(0);
            $table->string('nama')->nullable();
            $table->string('ket')->nullable();
            $table->string('color')->nullable();
            $table->string('color_div')->nullable();
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
        Schema::dropIfExists('master_statuses');
    }
}