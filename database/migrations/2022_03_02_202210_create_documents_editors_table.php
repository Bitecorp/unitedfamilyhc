<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDocumentsEditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_editors', function (Blueprint $table) {
            $table->id();
            $table->string('name_document_editor')->nullable();
            $table->string('backgroundImg')->nullable();
            $table->string('role_id')->nullable()->default('2');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE documents_editors ADD content LONGBLOB NULL AFTER backgroundImg");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_editors');
    }
}
