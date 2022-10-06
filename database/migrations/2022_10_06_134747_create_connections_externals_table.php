<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionsExternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections_externals', function (Blueprint $table) {
            $table->id();
            $table->string('name_connection')->nullable();
            $table->string('server_connection')->nullable();
            $table->string('port_connection')->nullable();
            $table->string('user_connection')->nullable();
            $table->string('password_connection')->nullable();
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
        Schema::dropIfExists('connections_externals');
    }
}
