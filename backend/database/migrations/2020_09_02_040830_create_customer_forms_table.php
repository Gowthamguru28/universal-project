<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->string('vehicle_no');
            $table->year('vehicle_year');
            $table->string('class_no');
            $table->string('engine_no');
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->string('owner_name');
            $table->string('phone');
            $table->longtext('address');
            $table->unsignedBigInteger('rto_id');
            $table->foreign('rto_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('class_3');
            $table->string('class_4');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('customer_forms');
    }
}
