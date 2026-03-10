<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspacosTable extends Migration
{
    public function up()
    {
        Schema::create('espacos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('imagem')->nullable(); // Para armazenar o caminho da imagem
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('espacos'); // Remove a tabela se existir
    }
}
