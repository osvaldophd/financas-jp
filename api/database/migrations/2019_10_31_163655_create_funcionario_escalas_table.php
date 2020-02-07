<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarioEscalasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario_escalas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('funcionario_id');
            $table->unsignedInteger('escala_id');
            $table->unsignedInteger('dia');
            $table->timestamps();

            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
            $table->foreign('escala_id')->references('id')->on('escalas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionario_escalas');
    }
}
