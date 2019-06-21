<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumniDataCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_data_collections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('image_id')->nullable();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('programme')->nullable();
            $table->string('branch')->nullable();
            $table->year('batch')->nullable();
            $table->year('passing')->nullable();
            $table->string('organisation')->nullable();

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
        Schema::dropIfExists('alumni_data_collections');
    }
}
