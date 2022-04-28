<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mi')->nullable();
            $table->string('street_addres')->nullable();
            $table->string('apartment_unit')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('ssn')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('email')->unique()->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('role_id');
            $table->string('statu_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
