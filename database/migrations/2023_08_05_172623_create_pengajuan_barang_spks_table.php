<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanBarangSpksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_barang_spks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->unsignedBigInteger('work_step_list_id');
            $table->foreign('work_step_list_id')->references('id')->on('work_step_lists');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('tgl_pengajuan')->nullable();
            $table->date('tgl_target_datang')->nullable();
            $table->date('tgl_tersedia')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->string('state')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('qty_barang')->nullable();
            $table->longtext('keterangan')->nullable();
            $table->string('harga_satuan')->nullable();
            $table->string('qty_purchase')->nullable();
            $table->string('stock')->nullable();
            $table->string('total_harga')->nullable();
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
        Schema::dropIfExists('pengajuan_barang_spks');
    }
}
