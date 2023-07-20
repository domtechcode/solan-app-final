<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instruction_id');
            $table->foreign('instruction_id')->references('id')->on('instructions')->onDelete('cascade');
            $table->unsignedBigInteger('work_step_list_id');
            $table->foreign('work_step_list_id')->references('id')->on('work_step_lists');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            // $table->unsignedBigInteger('job_id')->nullable();
            // $table->foreign('job_id')->references('id')->on('jobs');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->date('target_date')->nullable();
            $table->date('schedule_date')->nullable();
            $table->string('target_time')->nullable();

            $table->string('step')->nullable();
            $table->string('state_task')->nullable();
            $table->string('status_task')->nullable();
            $table->string('reject_from_id')->nullable();
            $table->string('reject_from_status')->nullable();
            $table->string('reject_from_job')->nullable();
            $table->string('task_priority')->nullable();

            $table->timestamp('dikerjakan')->nullable();
            $table->timestamp('selesai')->nullable();

            
            $table->string('spk_status')->nullable();
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
        Schema::dropIfExists('work_steps');
    }
}
