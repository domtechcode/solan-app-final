<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanPengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('form_pengajuan_barang_spk_id')->nullable();
            $table->string('form_pengajuan_barang_personal_id')->nullable();
            $table->string('form_pengajuan_maklun_id')->nullable();
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
        Schema::dropIfExists('catatan_pengajuans');
    }
}
