<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_services', function (Blueprint $table) {
            $table->dropColumn('frequency')->nullable();
            $table->dropColumn('billin_code')->nullable();
            $table->dropColumn('aditional_one')->nullable();
            $table->dropColumn('aditional_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_services', function (Blueprint $table) {
            //
        });
    }
}
