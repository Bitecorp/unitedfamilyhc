<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigSubServicesPatientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_sub_services_patientes', function (Blueprint $table) {
            $table->id();
            $table->string('salary_service_assigned_id')->nullable();
            $table->string('agent_id')->nullable();
            $table->string('code_patiente')->nullable();
            $table->string('approved_units')->nullable();
            $table->date('date_expedition')->nullable();
            $table->date('date_expired')->nullable();
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
        Schema::dropIfExists('config_sub_services_patientes');
    }
}
