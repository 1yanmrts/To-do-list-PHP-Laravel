<div id="modalNovaTarefa" class="modal-overlay">
    <div class="modal-box">
        <h2>Nova Tarefa</h2>

        <form action="{{ route('tarefas.store') }}" method="POST">
            @csrf
            @include('partials.formulario-tarefa')

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-cancelar"
                    onclick="fecharModalNovaTarefa()"
                >
                    Cancelar
                </button>

                <button type="submit" class="btn-salvar">
                    Salvar
                </button>
            </div>
        </form>
    </div>
</div>