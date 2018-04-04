<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('participant_id')->unsigned();
            $table->integer('depends_on')->unsigned()->nullable();
            $table->integer('round_1')->unsigned()->nullable();
            $table->integer('round_2')->unsigned()->nullable();
            $table->integer('spare')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('participant_id')
                    ->references('id')->on('participants')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_preferences');
    }
}
