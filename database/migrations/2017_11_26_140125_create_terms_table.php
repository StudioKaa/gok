<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Term;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->integer('enrollment_id');
            $table->decimal('amount', 10, 2);
            $table->string('mollie_id')->nullable();
            $table->string('date');
            $table->integer('state')->default(Term::STATE_OPEN);
            $table->timestamps();
        });

        $table->foreign('enrollment_id')
                    ->references('id')->on('enrollments')
                    ->onDelete('cascade');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
}
