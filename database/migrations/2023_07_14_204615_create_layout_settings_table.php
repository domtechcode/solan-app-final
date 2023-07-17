<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('form_id')->nullable();
            $table->string('state')->nullable();
            $table->string('panjang_barang_jadi')->nullable();
            $table->string('lebar_barang_jadi')->nullable();
            $table->string('panjang_bahan_cetak')->nullable();
            $table->string('lebar_bahan_cetak')->nullable();
            $table->string('panjang_naik')->nullable();
            $table->string('lebar_naik')->nullable();
            $table->string('jarak_panjang')->nullable();
            $table->string('jarak_lebar')->nullable();
            $table->string('sisi_atas')->nullable();
            $table->string('sisi_bawah')->nullable();
            $table->string('sisi_kiri')->nullable();
            $table->string('sisi_kanan')->nullable();
            $table->string('jarak_tambahan_vertical')->nullable();
            $table->string('jarak_tambahan_horizontal')->nullable();
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
        Schema::dropIfExists('layout_settings');
    }
}
