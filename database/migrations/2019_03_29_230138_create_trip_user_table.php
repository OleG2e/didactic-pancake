<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('trip_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unique(['trip_id', 'user_id']);
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
        Schema::dropIfExists('trip_user');
    }
}
