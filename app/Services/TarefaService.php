<?php

namespace App\Services;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Exception;

class TarefaService
{

    public function criarTarefa(array $dadosValidados)
    {
        return Tarefa::create($dadosValidados); 
    }

    public function alternarStatus(int $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->concluida = !$tarefa->concluida;
        $tarefa->save();

        return $tarefa;
    }

    public function deletarTarefa(int $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
    }

    public function atualizarTarefa(int $id, array $dadosValidados) 
    {
        $tarefa = Tarefa::findOrFail($id);
        
        // Passamos o array com os novos dados para o update
        if (!$tarefa->update($dadosValidados)) {
            throw new Exception('Não foi possível atualizar esta tarefa.');
        }

        return $tarefa;
    }
}
