<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalaryServicesAssignedTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_service_assigneds', function (Blueprint $table) {
            $table->string('frequency')->nullable();
            $table->string('billin_code')->nullable();
            $table->string('aditional_one')->nullable();
            $table->string('aditional_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_service_assigneds', function (Blueprint $table) {
            //
        });
    }
}
