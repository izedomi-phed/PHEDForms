<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDlEnhanceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dl_enhance_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id')->nullable();
            $table->string('staff_id')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('staff_type')->nullable();
            $table->string('job_desc')->nullable();
            $table->string('role')->nullable();
            $table->string('access_level')->nullable();
            $table->string('location')->nullable();
            $table->string('department')->nullable();
            $table->string('termination_date')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('work_no')->nullable();
            $table->string('hod_name')->nullable();
            $table->string('hod_email')->nullable();
            $table->string('hod_action_date')->nullable();
            $table->string('hod_comment')->nullable();
            $table->string('audit_name')->nullable();
            $table->string('audit_email')->nullable();
            $table->string('audit_action_date')->nullable();
            $table->string('audit_comment')->nullable();
            $table->string('it_action_date')->nullable();
            $table->string('it_comment')->nullable();
            $table->string('creator_action_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('dl_enhance_requests');
    }
}
