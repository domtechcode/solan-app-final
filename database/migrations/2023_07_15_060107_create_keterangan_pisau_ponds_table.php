<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeteranganPisauPondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterangan_pisau_ponds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('keterangan_id');
            $table->foreign('keterangan_id')->references('id')->on('keterangans')->onDelete('cascade');
            $table->string('state_pisau')->nullable();
            $table->string('jumlah_pisau')->nullable();
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
        Schema::dropIfExists('keterangan_pisau_ponds');
    }
}
