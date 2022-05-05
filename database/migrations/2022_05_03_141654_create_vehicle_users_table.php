<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_users', function (Blueprint $table) {
            $table->string('vehicle_plate')->primaryKey();
            $table->string('vehicle_brand');
            $table->integer('vehicle_model');
            $table->unsignedBigInteger('id_vehicle_type');
            $table->unsignedBigInteger('document_number');

            $table->foreign('id_vehicle_type')->references('id')->on('vehicle_types');
            $table->foreign('document_number')->references('document_number')->on('users');
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
        Schema::dropIfExists('vehicle_users');
    }
}