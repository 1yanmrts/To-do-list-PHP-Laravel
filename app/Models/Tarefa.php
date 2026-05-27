<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $table = 'tarefas';

    protected $fillable = [
        'nome',
        'data_limite',
        'descricao',
    ];

    // faz o cast para o Laravel saber que não é um texto comum e sim uma data
    protected $casts = [
        'data_limite' => 'date',
    ];
}
