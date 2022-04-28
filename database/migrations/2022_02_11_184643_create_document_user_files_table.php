<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentUserFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_user_files', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('document_id')->nullable();
            $table->date('date_expedition')->nullable();
            $table->date('date_expired')->nullable();
            $table->string('file')->unique();
            $table->string('expired')->nullable()->default('0');
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
        Schema::dropIfExists('document_user_files');
    }
}
