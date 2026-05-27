<?php

use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TarefaController::class, 'index'])->name('tarefas.index');
Route::get('/tabela', [TarefaController::class, 'tabela'])->name('tarefas.tabela');

Route::post('/tarefas', [TarefaController::class, 'salvar'])->name('tarefas.store');
Route::put('/tarefas/{id}', [TarefaController::class, 'atualizar'])->name('tarefas.update');
Route::delete('/tarefas/{id}', [TarefaController::class, 'deletar'])->name('tarefas.destroy');
Route::patch('/tarefas/{id}/concluir', [TarefaController::class, 'concluir'])->name('tarefas.concluir');