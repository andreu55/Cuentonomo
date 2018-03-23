<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('email_public')->nullable();
            $table->unsignedTinyInteger('horas_por_jornada')->default(8);
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_uno')->nullable();
            $table->string('address_dos')->nullable();
            $table->unsignedTinyInteger('irpf')->default(7);
            $table->unsignedTinyInteger('iva')->default(21);
            $table->string('banco_name')->nullable();
            $table->string('banco_cuenta')->nullable();
            $table->string('api_token', 60)->nullable();
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
