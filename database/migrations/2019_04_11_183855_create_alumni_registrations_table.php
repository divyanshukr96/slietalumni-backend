<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumniRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('image_id')->nullable();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('programme');
            $table->string('branch');
            $table->year('batch')->nullable();
            $table->year('passing')->nullable();
            $table->string('organisation')->nullable();
            $table->string('designation')->nullable();
            $table->string('linkdein')->nullable();

            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();

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
        Schema::dropIfExists('alumni_registrations');
    }
}
