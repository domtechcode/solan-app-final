<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormSortirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_sortirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('jenis_pekerjaan')->nullable();
            $table->string('pekerjaan_sebelum')->nullable();
            $table->string('pekerjaan_sesudah')->nullable();
            $table->string('hasil_akhir')->nullable();
            $table->string('jumlah_barang_gagal')->nullable();
            $table->string('satuan')->nullable();
            $table->string('nama_anggota')->nullable();
            $table->string('hasil_per_anggota')->nullable();
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
        Schema::dropIfExists('form_sortirs');
    }
}
