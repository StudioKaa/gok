<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('slug')->nullable();
            $table->integer('state');
            $table->integer('cp_participant_id')->nullable();
            $table->text('cp_email')->nullable();
            $table->integer('cp_phone')->nullable();
            $table->string('equipment');
            $table->string('equipment_size')->nullable();
            $table->string('arrival')->nullable();
            $table->timestamps();
        });

        //TODO: set relation
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
