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
        'user_id',
        'data_conclusao'
    ];

    protected $casts = [
        'data_limite' => 'date',
        'data_conclusao' => 'datetime'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
