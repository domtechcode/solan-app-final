<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutBahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_bahans', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('instruction_id');
            // $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('form_id')->nullable();
            $table->string('panjang_barang_jadi')->nullable();
            $table->string('lebar_barang_jadi')->nullable();
            $table->string('panjang_bahan_cetak')->nullable();
            $table->string('lebar_bahan_cetak')->nullable();
            $table->longText('dataURL')->nullable();
            $table->json('dataJSON')->nullable();
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
        Schema::dropIfExists('layout_bahans');
    }
}
