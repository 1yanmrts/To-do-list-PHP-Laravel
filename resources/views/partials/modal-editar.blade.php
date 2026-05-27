<div id="modalEditar" class="modal-overlay">
    <div class="modal-box">
        <h2>Editar Tarefa</h2>

        <form id="formEditar" method="POST">
            @csrf
            @method('PUT')

            @include('partials.formulario-tarefa')

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-cancelar"
                    onclick="fecharModalEditar()"
                >
                    Cancelar
                </button>

                <button type="submit" class="btn-salvar">
                    Atualizar
                </button>
            </div>
        </form>
    </div>
</div>