<div style="display: flex; gap: 10px; justify-content: center;">
    
    <button type="button" title="Editar" 
            style="background: transparent; border: none; cursor: pointer; color: #888; font-size: 16px;"
            data-id="{{ $tarefa->id }}"
            data-nome="{{ $tarefa->nome }}"
            data-data="{{ $tarefa->data_limite ? \Carbon\Carbon::parse($tarefa->data_limite)->format('Y-m-d') : '' }}"
            data-desc="{{ $tarefa->descricao }}"
            onclick="abrirModalEditar(this)">
        <i class="fa-regular fa-pen-to-square"></i>
    </button>

    <button type="button" title="Excluir" 
            style="background: transparent; border: none; cursor: pointer; color: #888; font-size: 16px;"
            onclick="confirmarExclusaoTabela('{{ $tarefa->id }}')">
        <i class="fa-regular fa-trash-can"></i>
    </button>
    
</div>