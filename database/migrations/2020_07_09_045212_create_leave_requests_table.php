<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('staff_id');
            $table->string('email');
            $table->string('reason_for_absence');
            $table->string('no_of_days_of_absence')->nullable();
            $table->string('start_date')->nullable();
            $table->string('last_date')->nullable();
            $table->string('resumption_date')->nullable();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('designation')->nullable();
            $table->string('residential_address')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('personal_phone')->nullable();
            $table->string('relief_officer_email')->nullable();
            $table->string('supervisor_email')->nullable();
            $table->string('overall_supervisor_email')->nullable();
            $table->string('leave_categories')->nullable();
            $table->string('hand_over_materials')->nullable();
            $table->string('status')->nullable();
            $table->integer("level")->nullable();
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
        Schema::dropIfExists('leave_requests');
    }
}
