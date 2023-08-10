<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUkuranBahanCetakSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukuran_bahan_cetak_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layout_setting_id');
            $table->foreign('layout_setting_id')->references('id')->on('layout_settings')->onDelete('cascade');
            $table->string('panjang_bahan_cetak')->nullable();
            $table->string('lebar_bahan_cetak')->nullable();
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
        Schema::dropIfExists('ukuran_bahan_cetak_settings');
    }
}
