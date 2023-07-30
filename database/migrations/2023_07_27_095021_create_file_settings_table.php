<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('keperluan')->nullable();
            $table->string('ukuran_film')->nullable();
            $table->string('jumlah_film')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
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
        Schema::dropIfExists('file_settings');
    }
}
