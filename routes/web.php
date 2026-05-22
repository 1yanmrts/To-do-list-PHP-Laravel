<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

// 1. Rota para MOSTRAR a tela principal
Route::get('/', [TarefaController::class, 'index']);

Route::post('/salvar', [TarefaController::class, 'salvar']);//create

Route::patch('/concluir/{id}', [TarefaController::class, 'concluir']);//read(?)

Route::put('/atualizar/{id}', [TarefaController::class, 'atualizar']);//update

Route::delete('/deletar/{id}', [TarefaController::class, 'deletar']);//delete

Route::get('/tabela', [TarefaController::class, 'tabela']);