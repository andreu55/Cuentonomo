<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num', 30);
            $table->unsignedSmallInteger('user_id');
            $table->unsignedSmallInteger('client_id')->nullable();
            $table->unsignedSmallInteger('horas')->default(0);
            $table->unsignedDecimal('precio', 8, 2);
            $table->unsignedTinyInteger('pagada')->default(0);
            $table->unsignedTinyInteger('persona_fisica')->default(0);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
