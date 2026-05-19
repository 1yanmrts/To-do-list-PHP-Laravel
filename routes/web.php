<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;

// 1. Rota para MOSTRAR a tela principal
Route::get('/', [TarefaController::class, 'index']);

Route::post('/salvar', [TarefaController::class, 'salvar']);

Route::delete('/deletar/{id}', [TarefaController::class, 'deletar']);

Route::patch('/concluir/{id}', [TarefaController::class, 'concluir']);

Route::put('/atualizar/{id}', [TarefaController::class, 'atualizar']);