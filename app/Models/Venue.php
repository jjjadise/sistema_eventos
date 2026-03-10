<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $table = 'espacos';

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
