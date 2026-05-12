<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Tarefa; // Importa o modelo que criamos antes!
use App\Http\Controllers\TarefaController;

// 1. Rota para MOSTRAR a tela principal
Route::get('/', function () {
    // Busca todas as tarefas salvas no banco de dados
    $tarefas = Tarefa::all(); 
    
    // Retorna a tela (view) chamada 'tarefas' passando a lista para ela
    return view('tarefas', ['tarefas' => $tarefas]); 
});

/*
Route::post('/salvar', function (Request $request) {
    // Cria uma nova tarefa em branco
    $novaTarefa = new Tarefa(); 
    
    // Preenche o nome com o que veio do formulário
    $novaTarefa->nome = $request->nome; 
    
    // Salva no banco de dados!
    $novaTarefa->save(); 
    
    // Redireciona de volta para a página inicial
    return redirect('/'); 
});
*/

Route::post('/salvar', [TarefaController::class, 'salvar']);

/*
// 3. Rota para DELETAR uma tarefa
Route::delete('/deletar/{id}', function ($id) {
    //procura a tarefa pelo id 
    $tarefa = Tarefa::findOrFail($id);

    //deleta a tarefa efetivamente
    $tarefa->delete();

    //retorna para a página inicial 
    return redirect('/'); 
});
8
*/

Route::delete('/deletar/{id}', [TarefaController::class, 'deletar']);

/*
// 4. Rota para ATUALIZAR uma tarefa (marcar ela como concluída ou desmarcar como concluída)
Route::patch('/concluir/{id}', function ($id){
    //procura a tarefa pelo id 
    $tarefa = Tarefa::findOrFail($id);

    //atualiza a tarefa, se for true vira false e se for false vira true (marca ou desmarca)
    $tarefa->concluida = !$tarefa->concluida;

    $tarefa->save();

    //retorna para a página inicial 
    return redirect('/'); 
});
*/

Route::patch('/concluir/{id}', [TarefaController::class, 'concluir']);