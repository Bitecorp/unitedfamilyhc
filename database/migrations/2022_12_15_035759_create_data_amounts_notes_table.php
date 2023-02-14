<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataAmountsNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_amounts_notes', function (Blueprint $table) {
            $table->id();
            $table->string('note_id')->required();            
            $table->string('customer_billing')->required();
            $table->string('type_customer')->required();
            $table->string('patiente_unit_time_id')->required();
            $table->string('worker_payment')->required();
            $table->string('type_payment')->required();
            $table->string('worker_unit_time_id')->required();
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
        Schema::dropIfExists('data_amounts_notes');
    }
}
