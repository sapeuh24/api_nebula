<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('id_parking');
            $table->double('discount_value', 10, 2)->nullable();
            $table->time('initial_time');
            $table->time('final_time')->nullable();
            $table->double('total_value', 10, 2)->nullable();
            $table->string('vehicle_plate');

            $table->foreign('id_parking')->references('id')->on('parkings');
            $table->foreign('vehicle_plate')->references('vehicle_plate')->on('vehicle_users');
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
        Schema::dropIfExists('tickets');
    }
}