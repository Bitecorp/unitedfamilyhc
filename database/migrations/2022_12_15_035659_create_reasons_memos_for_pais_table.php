<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReasonsMemosForPaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reasons_memos_for_pais', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->required();
            $table->string('patiente_id')->required();
            $table->string('service_id')->required();
            $table->string('sub_service_id')->required();
            $table->string('from')->required();
            $table->string('to')->required();
            $table->string('amount_base')->required();
            $table->string('reasons_id')->required();
            $table->string('monts_memo')->required();
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
        Schema::dropIfExists('reasons_memos_for_pais');
    }
}
