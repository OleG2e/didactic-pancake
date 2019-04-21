<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('startpoint_id');
            $table->unsignedInteger('endpoint_id');
            $table->unsignedInteger('passengers_count');
            $table->unsignedInteger('price_id');
            $table->dateTime('date_time');
            $table->text('description')->nullable();
            $table->text('price');
            $table->boolean('load')->default(false);
            $table->boolean('relevance')->default(true);
            $table->timestamps();

            //$table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
