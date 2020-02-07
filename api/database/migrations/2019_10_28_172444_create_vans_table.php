<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula')->unique();
            $table->string('descricao')->nullable();
            $table->unsignedInteger('modelo_id');
            $table->unsignedInteger('cor_id')->nullable();
            $table->string('imagem')->nullable();
            $table->unsignedInteger('ano_aquisicao')->nullable();
            $table->unsignedInteger('nr_ocupantes')->nullable();
            $table->timestamps();

            $table->foreign('modelo_id')->references('id')->on('modelos')->onDelete('cascade');
            $table->foreign('cor_id')->references('id')->on('cores')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vans');
    }
}
