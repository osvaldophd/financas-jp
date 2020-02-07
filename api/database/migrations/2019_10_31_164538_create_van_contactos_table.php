<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVanContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('van_contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contacto');
            $table->unsignedInteger('van_id');
            $table->timestamps();

            $table->foreign('van_id')->references('id')->on('vans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('van_contactos');
    }
}
