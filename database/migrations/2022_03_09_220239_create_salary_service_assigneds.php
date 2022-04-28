<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryServiceAssigneds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_service_assigneds', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('service_id')->nullable();
            $table->boolean('type_salary')->default(false);
            $table->string('salary')->nullable();
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
        Schema::dropIfExists('salary_service_assigneds');
    }
}
