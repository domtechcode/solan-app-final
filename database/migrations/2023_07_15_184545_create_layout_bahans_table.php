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
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('form_id')->nullable();
            $table->string('state')->nullable();
            $table->string('include_belakang')->nullable();
            $table->string('panjang_plano')->nullable();
            $table->string('lebar_plano')->nullable();
            $table->string('panjang_bahan_cetak')->nullable();
            $table->string('lebar_bahan_cetak')->nullable();
            $table->string('jenis_bahan')->nullable();
            $table->string('gramasi')->nullable();
            $table->string('one_plano')->nullable();
            $table->string('sumber_bahan')->nullable();
            $table->string('merk_bahan')->nullable();
            $table->string('supplier')->nullable();
            $table->string('jumlah_lembar_cetak')->nullable();
            $table->string('jumlah_incit')->nullable();
            $table->string('total_lembar_cetak')->nullable();
            $table->string('harga_bahan')->nullable();
            $table->string('jumlah_bahan')->nullable();
            $table->string('panjang_sisa_bahan')->nullable();
            $table->string('lebar_sisa_bahan')->nullable();
            $table->longText('dataURL')->nullable();
            $table->json('dataJSON')->nullable();
            $table->string('layout_custom_file_name')->nullable();
            $table->string('layout_custom_path')->nullable();
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
