<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumniMeetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_meets', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id')->nullable();
            $table->string('meet_id')->unique()->nullable();

            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('programme')->nullable();
            $table->string('branch')->nullable();
            $table->year('batch')->nullable();
            $table->year('passing')->nullable();
            $table->string('organisation')->nullable();
            $table->string('designation')->nullable();

            $table->boolean('family')->default(false);
            $table->boolean('accommodation')->default(false);
            $table->text('requirements')->nullable();

            $table->boolean('verified')->default(false);
            $table->text('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();


            $table->year('year')->nullable();
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
        Schema::dropIfExists('alumni_meets');
    }
}
