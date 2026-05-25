<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables - Tarefas</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 20px; }
        .btn-voltar { display: inline-block; margin-bottom: 20px; padding: 10px 15px; background: #888; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-voltar:hover { background: #555; }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center; align-items: center;
            z-index: 1000;
        }
        .modal-box {
            background: white; padding: 25px; border-radius: 8px;
            width: 500px; max-width: 90%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .modal-box h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .modal-box label { display: block; font-size: 14px; font-weight: bold; color: #555; margin-bottom: 5px; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; }
        .btn-cancelar { padding: 10px 15px; background: white; color: #555; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; }
        .btn-salvar { padding: 10px 15px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

    <div class="container">
       <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="/" class="btn-voltar" style="margin-bottom: 0;">
                <i class="fa-solid fa-arrow-left"></i> Voltar para os Cards
            </a>
            
            <button onclick="document.getElementById('modalNovaTarefa').style.display='flex'" class="btn-salvar">
                <i class="fa-solid fa-plus"></i> Nova Tarefa
            </button>
        </div>

        <h1>Relatório de Tarefas</h1>

        <div id="modalEditar" class="modal-overlay">
            <div class="modal-box">
                <h2>Editar Tarefa</h2>
                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <label>Título *</label>
                    <input type="text" name="nome" id="edit_nome" maxlength="128" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;">
                    
                    <label>Data *</label>
                    <input type="date" name="data_limite" id="edit_data" min="{{ now()->format('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;">
                    
                    <label>Descrição da tarefa</label>
                    <textarea name="descricao" id="edit_descricao" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;"></textarea>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn-cancelar" onclick="fecharModalEditar()">Cancelar</button>
                        <button type="submit" class="btn-salvar">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalNovaTarefa" class="modal-overlay">
        <div class="modal-box">
            <h2>Nova Tarefa</h2>
            <form action="/salvar" method="POST">
                @csrf
                <label>Título *</label>
                <input type="text" name="nome" maxlength="128" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;">
                
                <label>Data *</label>
                <input type="date" name="data_limite" min="{{ now()->format('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;">
                
                <label>Descrição da tarefa</label>
                <textarea name="descricao" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box;"></textarea>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" onclick="fecharModalNovaTarefa()">Cancelar</button>
                    <button type="submit" class="btn-salvar">Salvar</button>
                </div>
            </form>
        </div>
    </div>

        {{ $dataTable->table() }}
        
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    {{ $dataTable->scripts() }}

    <script>
        function abrirModalNovaTarefa() {
            document.getElementById('modalNovaTarefa').style.display = 'flex';
        }

        function fecharModalNovaTarefa() {
            document.getElementById('modalNovaTarefa').style.display = 'none';
        }

        function alternarStatusTabela(id, checkbox) {
            fetch('/concluir/' + id, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json', // Importante para o expectsJson() funcionar no Controller
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (!response.ok) {
                    alert('Erro ao atualizar o status. Tente novamente.');
                    checkbox.checked = !checkbox.checked; // desfaz o check visual se der erro
                }
            });
        }

        function abrirModalEditar(botao) {
            const id = botao.getAttribute('data-id');
            const nome = botao.getAttribute('data-nome');
            const data = botao.getAttribute('data-data');
            const descricao = botao.getAttribute('data-desc');

            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_data').value = data;
            document.getElementById('edit_descricao').value = descricao;

            document.getElementById('formEditar').action = '/atualizar/' + id;
            document.getElementById('modalEditar').style.display = 'flex';
        }

        function fecharModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        function confirmarExclusaoTabela(id) {
            if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
                // Cria um formulário dinâmico em JS para enviar o DELETE pro Laravel
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/deletar/' + id;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                
                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

</body>
</html>