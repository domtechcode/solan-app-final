<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeteranganPlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterangan_plates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->unsignedBigInteger('keterangan_id');
            $table->foreign('keterangan_id')->references('id')->on('keterangans')->onDelete('cascade');
            $table->string('state_plate')->nullable();
            $table->integer('jumlah_plate')->nullable();
            $table->string('ukuran_plate')->nullable();
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
        Schema::dropIfExists('keterangan_plates');
    }
}
