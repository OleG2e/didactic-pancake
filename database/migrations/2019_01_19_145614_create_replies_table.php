<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'replies',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('owner_id');
                $table->unsignedInteger('model_id');
                $table->char('model_name', 16);
                $table->json('attachment')->nullable();
                $table->text('description');
                $table->boolean('edited')->default(false);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
