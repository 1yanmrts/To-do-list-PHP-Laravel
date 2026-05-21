<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;}
        input[type="text"] { width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #eee; }
        h1 { font-size: 32px; font-weight: bold; text-align: center; margin-bottom: 25px; color: #333; }
        
        .form-tarefa { display: flex; align-items: center; gap: 12px; }
        .form-tarefa input[type="text"] { flex: 1; padding: 12px; font-size: 16px; }
        .form-tarefa button { width: 50px; height: 50px; }
        
        .calendario { position: relative; width: 35px; height: 35px; display: flex; justify-content: center; align-items: center; cursor: pointer; }
        .calendario i { font-size: 28px; color: #888; pointer-events: none; }
        .calendario:hover i { color: #191a19; }
        .calendario input { position: absolute; width: 1px; height: 1px; opacity: 0; border: none; pointer-events: none; }
        
        .item-tarefa { position: relative; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; gap: 10px; padding-bottom: 15px; }
        .data-limite { font-size: 14px; color: #666; margin-right: 5px; } 
        
        .btn-add { padding: 10px 15px; background: #888; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn-add:hover { background: #191a19; }
        

        .acoes-tarefa {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .btn-marcar,
        .btn-atualizar,
        .btn-lixeira {
            width: 22px;
            height: 22px;
            
            display: flex;
            justify-content: center;
            align-items: center;

            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;

            transition: 0.2s ease;
        }

        .btn-marcar {
            border: 2px solid #c7c7c7;
            border-radius: 5px;
            color: #888;
            font-size: 12px;
        }

        .btn-marcar:hover {
            border-color: #191a19;
            color: #191a19;
        }

        .btn-atualizar i,
        .btn-lixeira i {
            font-size: 18px;
            color: #999;
            opacity: 0.7;
        }

        .btn-atualizar:hover i {
            color: #191a19;
            opacity: 1;
            transform: scale(1.08);
        }

        .btn-atualizar { margin-right: -4px;} /* colocar o botão um pouco mais a direita */

        .btn-lixeira:hover i {
            color: #191a19;
            opacity: 1;
            transform: scale(1.08);
        }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none; /* Escondido por padrão */
            justify-content: center; align-items: center;
            z-index: 1000;
        }
        
        .modal-box {
            background: white; padding: 25px; border-radius: 8px;
            width: 500px; max-width: 90%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .modal-box h2 { margin-top: 0; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; word-break: break-all; overflow-wrap: break-word;}
        .modal-box label { display: block; font-size: 14px; font-weight: bold; color: #555; margin-bottom: 5px; }
        .modal-box input[type="date"], .modal-box textarea { 
            width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 15px; box-sizing: border-box; font-family: inherit;
        }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; }
        .btn-cancelar { padding: 10px 15px; background: white; color: #555; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; }
        .btn-cancelar:hover { background: #a1a0a0;  }
        .btn-salvar { padding: 10px 15px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-salvar:hover { background: #234883 }

    </style>
</head>

<body>
    <div class="container">
        <h1>Lista de Tarefas</h1>

        <script>
        function abrirCalendario() {
            document.getElementById('data_limite').showPicker();
        }
        </script>
        
        {{-- versão nova com sweetalert --}}
        <div>
            @if ($errors->any())
                <script type="module">
                    window.Swal.fire({
                        icon: 'error',
                        title: 'Ops! Tem algo errado.',
                        // Pega a primeira mensagem de erro e exibe
                        text: '{{ $errors->first() }}', 
                        confirmButtonColor: '#d33'
                    });
                </script>
            @endif
        <div>

        <form onsubmit="abrirModal(event)" class="form-tarefa">
            <input type="text" id="nome_tarefa_rapida" placeholder="Digite uma nova tarefa..." required>
            
            <button type="submit" class="btn-add">
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>
        

        <br>

        <ul>
        @foreach($tarefas as $tarefa)
                @php
                    // Verifica se a data existe, se a tarefa está pendente e se a data limite é menor (isBefore) que a data de hoje (today())
                    $atrasada = $tarefa->data_limite && !$tarefa->concluida && \Carbon\Carbon::parse($tarefa->data_limite)->isBefore(today());
                    
                    // Definimos a cor do título baseado no status:
                    $corTitulo = $tarefa->concluida ? '#888' : ($atrasada ? '#dc3545' : '#333');
                @endphp

                <li class="item-tarefa">    
                    
                    <div style="flex: 1; min-width: 0; padding-right: 15px; display: flex; flex-direction: column; gap: 5px;">
                        
                        <span style="font-weight: bold; font-size: 16px; overflow-wrap: break-word; word-break: break-word; {{ $tarefa->concluida ? 'text-decoration: line-through;' : '' }} color: {{ $corTitulo }};">
                            {{ $tarefa->nome }}
                        </span>
                        
                        @if($tarefa->descricao)
                            <span style="font-size: 14px; color: #666; overflow-wrap: break-word; word-break: break-word; line-height: 1.4; {{ $tarefa->concluida ? 'opacity: 0.6; ' : '' }} color: {{ $atrasada && !$tarefa->concluida ? '#dc3545' : '#666' }};">
                                {{ $tarefa->descricao }}
                            </span>
                        @endif
                    </div>
                    
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px;">
                        
                        <div class="acoes-tarefa">
                            <form action="/concluir/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" title="Marcar como concluída" class="btn-marcar">
                                    @if($tarefa->concluida)
                                        <i class="fa-solid fa-check"></i>
                                    @endif
                                </button>
                            </form>
                            
                            <button type="button" title="Editar tarefa" class="btn-atualizar"
                                data-id="{{ $tarefa->id }}"
                                data-nome="{{ $tarefa->nome }}"
                                data-data="{{ $tarefa->data_limite ? \Carbon\Carbon::parse($tarefa->data_limite)->format('Y-m-d') : '' }}"
                                data-desc="{{ $tarefa->descricao }}"
                                onclick="abrirModalEditar(this)">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>

                            <form action="/deletar/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Excluir tarefa" class="btn-lixeira">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>

                        @if($tarefa->data_limite)
                            <div class="data-limite" style="{{ $atrasada ? 'color: #dc3545;' : '' }}">
                                {{ \Carbon\Carbon::parse($tarefa->data_limite)->format('d/m') }}
                            </div>
                        @endif

                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div id="modalEditar" class="modal-overlay">
        <div class="modal-box">
            <h2>Editar Tarefa</h2>
            
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                
                <label>Título *</label>
                <input type="text" name="nome" id="edit_nome" maxlength="128" required>
                
                <label>Data *</label>
                <input type="date" name="data_limite" id="edit_data" min="{{ now()->format('Y-m-d') }}" required>
                
                <label>Descrição da tarefa</label>
                <textarea name="descricao" id="edit_descricao" rows="4"></textarea>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" onclick="fecharModalEditar()">Cancelar</button>
                    <button type="submit" class="btn-salvar">Atualizar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="meuModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="titulo_modal_tarefa">Nova tarefa</h2>
            
            <form action="/salvar" method="POST">
                @csrf
                
                <input type="hidden" name="nome" id="nome_tarefa_real">
                
                <label>Data *</label>
                <input type="date" name="data_limite" min="{{ now()->format('Y-m-d') }}" required>
                
                <label>Descrição da tarefa </label>
                <textarea name="descricao" rows="4" placeholder="Descreva os detalhes da sua tarefa..."></textarea>
                
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
                    <button type="submit" class="btn-salvar">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(event) {
            // Impede a página de recarregar
            event.preventDefault(); 
            
            // Pega o texto que o usuário digitou
            const nomeDigitado = document.getElementById('nome_tarefa_rapida').value;

            if (nomeDigitado.length > 128) {
                // Chama o pop-up do SweetAlert
                window.Swal.fire({
                    icon: 'warning',
                    title: 'Título muito longo!',
                    text: 'O nome da tarefa não pode ultrapassar 128 caracteres.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            // Joga o texto no campo invisível do modal
            document.getElementById('nome_tarefa_real').value = nomeDigitado;

            // Troca o texto do <h2> pelo nome que demos a tarefa.
            document.getElementById('titulo_modal_tarefa').innerText = nomeDigitado;
            
            // Mostra o modal na tela alterando o display de none para flex
            document.getElementById('meuModal').style.display = 'flex';
        }

        function fecharModal() {
            // Esconde o modal
            document.getElementById('meuModal').style.display = 'none';
        }

        function abrirModalEditar(botao) {
            // Pega os dados escondidos no botão
            const id = botao.getAttribute('data-id');
            const nome = botao.getAttribute('data-nome');
            const data = botao.getAttribute('data-data');
            const descricao = botao.getAttribute('data-desc');

            // Preenche os campos do formulário
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_data').value = data;
            document.getElementById('edit_descricao').value = descricao;

            // Aponta o formulário para a URL certa
            document.getElementById('formEditar').action = '/atualizar/' + id;

            // Mostra o modal na tela
            document.getElementById('modalEditar').style.display = 'flex';
        }

        function fecharModalEditar() {
            document.getElementById('modalEditar').style.display = 'none';
        }
    </script>

</body>
</html>