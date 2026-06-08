<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Tarefa;
use Exception;

class TarefaService
{
    public function criarTarefa(array $dadosValidados): Tarefa
    {
        $dadosValidados['user_id'] = Auth::id();

        return Tarefa::create($dadosValidados);
    }

    public function alternarStatus(int $id): Tarefa
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->concluida = ! $tarefa->concluida;
        $tarefa->save();

        return $tarefa;
    }

    public function deletarTarefa(int $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
    }

    public function atualizarTarefa(int $id, array $dadosValidados): Tarefa
    {
        $tarefa = Tarefa::findOrFail($id);

        if (! $tarefa->update($dadosValidados)) {
            throw new Exception('Não foi possível atualizar esta tarefa.');
        }

        return $tarefa;
    }
}
