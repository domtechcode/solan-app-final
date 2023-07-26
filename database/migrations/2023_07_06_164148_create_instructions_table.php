<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->string('spk_number')->nullable();
            $table->string('spk_type')->nullable();
            $table->string('taxes_type')->nullable();
            // $table->string('spk_status')->nullable();
            $table->string('spk_state')->nullable();
            $table->string('repeat_from')->nullable();
            $table->string('request_kekurangan')->nullable();
            $table->string('spk_parent')->nullable();
            $table->string('sub_spk')->nullable();
            $table->string('spk_fsc')->nullable();
            $table->string('spk_number_fsc')->nullable();
            $table->string('fsc_type')->nullable();
            $table->date('order_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_number')->nullable();
            $table->string('order_name')->nullable();
            $table->string('code_style')->nullable();
            $table->string('quantity')->nullable();
            $table->string('stock')->nullable();
            $table->string('follow_up')->nullable();
            $table->string('spk_layout_number')->nullable();
            $table->string('spk_sample_number')->nullable();
            $table->string('price')->nullable();
            $table->string('group_id')->nullable();
            $table->string('group_priority')->nullable();
            $table->string('type_order')->nullable();
            $table->date('shipping_date_first')->nullable();
            $table->string('type_ppn')->nullable();
            $table->string('ppn')->nullable();
            $table->string('count')->nullable();
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
        Schema::dropIfExists('instructions');
    }
}
