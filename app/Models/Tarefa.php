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

    protected $casts = [
        'data_limite' => 'date',
    ];
}
