@extends('layouts.app')

@section('title', 'Relatorio de Tarefas')

@section('content')

<div class="topo-pagina">

    <a href="/" class="btn-voltar">
        <i class="fa-solid fa-arrow-left"></i>
        Voltar para os Cards
    </a>

    <button onclick="abrirModalNovaTarefa()" class="btn-salvar">
        <i class="fa-solid fa-plus"></i>
        Nova Tarefa
    </button>

</div>

<h1>Relatório de Tarefas</h1>

@include('partials.modal-editar')

@include('partials.modal-nova-tarefa')

{{ $dataTable->table() }}

@endsection

@push('scripts')
    {{ $dataTable->scripts(null, ['type' => 'module']) }}
@endpush