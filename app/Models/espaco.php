<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espaco extends Model
{
    protected $fillable = [
        'titulo',
        'slug',
        'imagem_capa',
        'conteudo',
    ];

    protected $casts = [
        'conteudo' => 'array',
    ];
}
