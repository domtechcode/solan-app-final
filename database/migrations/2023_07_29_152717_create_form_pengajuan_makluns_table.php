<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPengajuanMaklunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_pengajuan_makluns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('bentuk_maklun')->nullable();
            $table->string('rekanan')->nullable();
            $table->string('tgl_keluar')->nullable();
            $table->string('qty_keluar')->nullable();
            $table->string('satuan_keluar')->nullable();
            $table->string('status')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('harga_satuan_maklun')->nullable();
            $table->string('qty_purchase_maklun')->nullable();
            $table->string('total_harga_maklun')->nullable();
            $table->string('previous_state')->nullable();
            $table->string('rab')->nullable();
            $table->string('accounting')->nullable();
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
        Schema::dropIfExists('form_pengajuan_makluns');
    }
}
