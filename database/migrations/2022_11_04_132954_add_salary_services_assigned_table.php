<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalaryServicesAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salary_service_assigneds', function (Blueprint $table) {
            $table->string('workerIdIc')->nullable();
            $table->string('aditional_one_w')->nullable();
            $table->string('aditional_two_w')->nullable();
            $table->string('aditional_three_w')->nullable();
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
