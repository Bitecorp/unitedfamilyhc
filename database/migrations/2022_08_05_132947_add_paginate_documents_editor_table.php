<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaginateDocumentsEditorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents_editors', function (Blueprint $table) {
            $table->boolean('paginate')->default(1)->comment('para saber si lleva o no pie de pagina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents_editors', function (Blueprint $table) {
            //
        });
    }
}
