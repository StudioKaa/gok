<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order');
            $table->string('title');
            $table->integer('duration');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('age');
            $table->text('skills')->nullable();
            $table->text('particulars')->nullable();
            $table->text('description');
            $table->text('image');
            $table->string('location_generic');
            $table->string('location_specific')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
