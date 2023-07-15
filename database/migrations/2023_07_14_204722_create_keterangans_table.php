<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeterangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keterangans', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('instruction_id');
            // $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->string('form_id');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('keterangans');
    }
}
