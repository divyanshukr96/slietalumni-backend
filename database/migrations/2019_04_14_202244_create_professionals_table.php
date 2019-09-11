<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('professionalable_id')->nullable();
            $table->string('professionalable_type')->nullable();

            $table->string('organisation')->nullable();  // not nullable using validation
            $table->string('designation')->nullable();
            $table->string('org_address')->nullable();
            $table->string('org_contact')->nullable();
            $table->string('org_email')->nullable();

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
        Schema::dropIfExists('professionals');
    }
}
