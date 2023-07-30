<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRincianPlatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_plates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->unsignedBigInteger('keterangan_id');
            $table->foreign('keterangan_id')->references('id')->on('keterangans')->onDelete('cascade');
            $table->string('state')->nullable();
            $table->string('plate')->nullable();
            $table->string('jumlah_lembar_cetak')->nullable();
            $table->string('waste')->nullable();
            $table->string('name')->nullable();
            $table->string('tempat_plate')->nullable();
            $table->date('tgl_pembuatan_plate')->nullable();
            $table->string('status')->nullable();
            $table->string('de')->nullable();
            $table->string('l')->nullable();
            $table->string('a')->nullable();
            $table->string('b')->nullable();
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
        Schema::dropIfExists('rincian_plates');
    }
}
