<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarioContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario_contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contacto');
            $table->enum('tipo', ['telefone', 'telemovel', 'email', 'outro']);
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
        Schema::dropIfExists('funcionario_contactos');
    }
}
