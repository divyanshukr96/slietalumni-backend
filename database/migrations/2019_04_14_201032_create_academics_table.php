<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('academicable_id')->nullable();
            $table->string('academicable_type')->nullable();

            $table->string('programme')->nullable();  // not nullable using validator
            $table->string('branch')->nullable();
            $table->string('enrollment')->nullable();
            $table->year('passing')->nullable();
            $table->year('batch')->nullable();
            $table->string('registration')->nullable();
            $table->string('institute')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('academics');
    }
}
