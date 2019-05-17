<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('status')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('gender')->nullable();
            $table->string('employee_no')->unique()->nullable();
            $table->string('description')->nullable();
            $table->date('birthday')->nullable();
            $table->string('id_number')->unique()->nullable();
            $table->string('id_number_place')->nullable();
            $table->date('id_number_date')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('passport_place')->nullable();
            $table->date('passport_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('active_check')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address_details')->nullable();
            $table->integer('address_id')->nullable();
            $table->integer('role')->default(0);
            $table->string('tax_number')->nullable();

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
        Schema::dropIfExists('employees');
    }
}
