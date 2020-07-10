<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatoryLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatory_leave_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lr_id');
            $table->string('email');
            $table->string('role');
            $table->string('level');
            $table->string('completed')->default("FALSE");
            $table->string('comment')->nullable();
            $table->string('completed_date')->nullable();
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
        Schema::dropIfExists('signatory_leave_requests');
    }
}
