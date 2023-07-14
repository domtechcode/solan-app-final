<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormKeterangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_keterangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_layout_setting_id')->constrained('form_layout_settings')->onDelete('cascade');
            $table->string('panjang');
            $table->string('lebar');
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
        Schema::dropIfExists('form_keterangans');
    }
}
