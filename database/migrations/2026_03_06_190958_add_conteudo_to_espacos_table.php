<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('espacos', function (Blueprint $table) {
            $table->string('titulo')->nullable()->change();
            $table->string('slug')->unique()->nullable();
            $table->string('imagem_capa')->nullable();
            $table->json('conteudo')->nullable();
            $table->dropColumn('descricao');
            $table->dropColumn('imagem');
        });
    }

    public function down(): void
    {
        Schema::table('espacos', function (Blueprint $table) {
            $table->string('descricao')->nullable();
            $table->string('imagem')->nullable();
            $table->dropColumn(['slug', 'imagem_capa', 'conteudo']);
        });
    }
};
