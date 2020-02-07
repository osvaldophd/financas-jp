<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rua');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('numero_casa');
            $table->unsignedInteger('municipio_id');
            $table->unsignedInteger('funcionario_id');
            $table->timestamps();

            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moradas');
    }
}
