<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_information', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('work_name_location')->nullable();
            $table->string('work_phone')->nullable();
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
        Schema::dropIfExists('jobs_information');
    }
}
