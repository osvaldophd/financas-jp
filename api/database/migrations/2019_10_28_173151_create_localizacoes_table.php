<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalizacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('descricao')->nullable();
            $table->unsignedInteger('funcionario_id');
            $table->timestamps();

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
        Schema::dropIfExists('localizacoes');
    }
}
