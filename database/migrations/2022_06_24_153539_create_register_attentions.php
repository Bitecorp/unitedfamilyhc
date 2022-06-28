<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterAttentions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_attentions', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->nullable();
            $table->string('patiente_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('sub_service_id')->nullable();
            $table->dateTime('start')->nullable();
            $table->string('lat_start')->nullable();
            $table->string('long_start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('lat_end')->nullable();
            $table->string('long_end')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('register_attentions');
    }
}
