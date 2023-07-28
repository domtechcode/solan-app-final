<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_ponds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('hasil_akhir_pond')->nullable();
            $table->string('nama_pisau')->nullable();
            $table->string('lokasi_pisau')->nullable();
            $table->string('status_pisau')->nullable();
            $table->string('nama_matress')->nullable();
            $table->string('lokasi_matress')->nullable();
            $table->string('status_matress')->nullable();
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
        Schema::dropIfExists('form_ponds');
    }
}
