<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGenerateDocuments1099Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generate_documents_1099', function (Blueprint $table) {
            $table->dropColumn('patiente_id')->nullable();
            $table->dropColumn('sub_service_id')->nullable();
            $table->dropColumn('service_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_documents_1099', function (Blueprint $table) {
            //
        });
    }
}
