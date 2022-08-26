<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerateDocuments1099 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate_documents_1099', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id');
            $table->string('patiente_id');
            $table->string('service_id');
            $table->string('sub_service_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->string('eftor_check');
            $table->string('invoice_number')->nullable();
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
        Schema::dropIfExists('generate_documents_1099');
    }
}
