<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [TarefaController::class, 'tabela'])->name('dashboard');
    Route::get('/tarefas/create', [TarefaController::class, 'create'])->name('tarefas.create');
    Route::post('/tarefas', [TarefaController::class, 'salvar'])->name('tarefas.store');
    Route::put('/tarefas/{id}', [TarefaController::class, 'atualizar'])->name('tarefas.update');
    Route::delete('/tarefas/{id}', [TarefaController::class, 'deletar'])->name('tarefas.destroy');
    Route::patch('/tarefas/{id}/concluir', [TarefaController::class, 'concluir'])->name('tarefas.concluir');
    Route::get('/tarefas/{tarefa}/edit', [TarefaController::class, 'edit'])->name('tarefas.edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';