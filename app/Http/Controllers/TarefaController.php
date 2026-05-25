<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\TarefaDataTable;
use App\Http\Requests\SalvarTarefaRequest;
use App\Services\TarefaService;
use App\Models\Tarefa;
use Exception;

class TarefaController extends Controller
{
    protected $tarefaService;

    public function __construct(TarefaService $tarefa) 
    {
        $this->tarefaService = $tarefa;
    }

    public function index() 
    {
        // Busca todas as tarefas salvas no banco de dados
        $tarefas = Tarefa::all(); 
        
        // Retorna a tela (view) chamada 'tarefas' passando a lista para ela
        return view('tarefas', ['tarefas' => $tarefas]); 
    }

    public function salvar(SalvarTarefaRequest $request) 
    {
        try 
        {
            $dados = $request->validated();//passa a request para array para conseguirmos criar a tarefa     

            $this->tarefaService->criarTarefa($dados);
            
            return redirect('/tabela');

        } 
        catch (Exception $e) 
        {
            return back();
        }
    }

    public function deletar(int $id) 
    {
        try 
        {
            $this->tarefaService->deletarTarefa($id);

            return redirect('/tabela'); 
        }
        catch(Exception $e) 
        {
            return back();
        }
 
    }

    public function concluir(int $id) 
    {
        try 
        {
            $this->tarefaService->alternarStatus($id);

            if (request()->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect('/tabela');
        }
        catch(Exception $e) 
        {            
            return back()->withErrors(['error', $e->getMessage()]);
        }
    }

    public function atualizar(SalvarTarefaRequest $request, int $id) 
    {
        try 
        {
            $dados = $request->validated();//passa a request para array para conseguirmos criar a tarefa     

            $this->tarefaService->atualizarTarefa($id, $dados);
            
            return redirect('/tabela');

        } 
        catch (Exception $e) 
        {
            return back();
        }
    }


    public function tabela(TarefaDataTable $dataTable) 
    {
        return $dataTable->render('tabela-tarefas');
    }
}
