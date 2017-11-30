<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('enrollment_id')->unsigned();
            $table->boolean('is_member');
            $table->integer('member_id')->nullable();
            $table->string('name');
            $table->date('birthday');
            $table->string('diet')->nullable();
            $table->timestamps();

            $table->foreign('enrollment_id')
                    ->references('id')->on('enrollments')
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
        Schema::dropIfExists('participants');
    }
}
