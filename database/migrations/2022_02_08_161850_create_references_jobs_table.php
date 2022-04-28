<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('name_and_address')->nullable();
            $table->string('position')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('phone_supervisor')->nullable();
            $table->string('dates_employed')->nullable();
            $table->string('to_dates_employed')->nullable();
            $table->string('reason_leaving')->nullable();
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
        Schema::dropIfExists('references_jobs');
    }
}
