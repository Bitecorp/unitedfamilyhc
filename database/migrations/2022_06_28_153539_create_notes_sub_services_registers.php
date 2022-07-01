<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNotesSubServicesRegisters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_sub_services_registers', function (Blueprint $table) {
            $table->id();
            $table->string('register_attentions_id')->nullable();
            $table->string('worker_id')->nullable();
            $table->string('patiente_id')->nullable();
            $table->string('service_id')->nullable();
            $table->string('sub_service_id')->nullable();
            $table->longText('firma')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE notes_sub_services_registers ADD note LONGBLOB NULL AFTER sub_service_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes_sub_services_registers');
    }
}
