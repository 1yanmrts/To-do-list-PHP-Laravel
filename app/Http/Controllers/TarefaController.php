<?php

namespace App\Http\Controllers;

use App\DataTables\TarefaDataTable;
use App\Http\Requests\SalvarTarefaRequest;
use App\Models\Tarefa;
use App\Services\TarefaService;
use Illuminate\Support\Facades\Log;
use Exception;

class TarefaController extends Controller
{
    protected TarefaService $tarefaService;

    public function __construct(TarefaService $tarefa)
    {
        $this->tarefaService = $tarefa;
    }

    public function index()
    {
        $tarefas = Tarefa::all();

        return view('tarefas', ['tarefas' => $tarefas]);
    }

    public function salvar(SalvarTarefaRequest $request)
    {
        try {
            $dados = $request->validated();

            $this->tarefaService->criarTarefa($dados);

            return redirect('/tabela')->with('success', 'Tarefa criada com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao salvar o arquivo: '.$e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Ocorreu um erro ao tentar salvar a tarefa!']);
        }
    }

    public function deletar(int $id)
    {
        try {
            $this->tarefaService->deletarTarefa($id);

            return redirect('/tabela');

        } catch (Exception $e) {
            Log::error("Erro ao deletar a tarefa ID {$id}: ".$e->getMessage());

            return back()->withErrors(['error' => 'Não foi possível excluir a tarefa.']);
        }

    }

    public function concluir(int $id)
    {
        try {
            $this->tarefaService->alternarStatus($id);

            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect('/tabela');

        } catch (Exception $e) {
            Log::error("Erro ao alterar status da tarefa ID {$id}: ".$e->getMessage());

            if (request()->expectsJson()) {
                return response()->json(['error' => 'Ocorreu um erro interno.'], 500);
            }

            return back()->withErrors(['error' => 'Erro ao alterar status da tarefa ID {$id}']);
        }
    }

    public function atualizar(SalvarTarefaRequest $request, int $id)
    {
        try {
            $dados = $request->validated();

            $this->tarefaService->atualizarTarefa($id, $dados);

            return redirect('/tabela')->with('Tarefa atualizada com sucesso!');

        } catch (Exception $e) {
            Log::error('Erro ao atualizar a tarefa ID {$id}: '.$e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Ocorreu um erro ao tentar atualizar a tarefa!']);
        }
    }

    public function tabela(TarefaDataTable $dataTable)
    {
        return $dataTable->render('tabela-tarefas');
    }
}
