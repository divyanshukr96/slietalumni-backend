<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('event_type_id');

            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('venue')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();

            $table->boolean('published')->default(false);
            $table->string('published_by')->nullable();
            $table->timestamp('published_at')->nullable();

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
        Schema::dropIfExists('events');
    }
}
