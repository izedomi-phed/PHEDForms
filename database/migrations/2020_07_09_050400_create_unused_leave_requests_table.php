<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnusedLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unused_leave_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lr_id');
            $table->string('staff_id');
            $table->string('staff_email');
            $table->string('year');
            $table->string('no_of_days');
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
        Schema::dropIfExists('unused_leave_requests');
    }
}
