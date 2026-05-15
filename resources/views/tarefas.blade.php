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
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: left; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert ul { margin: 0; padding-left: 20px; }
        .alert li { border: none; background: transparent; box-shadow: none; }
        button { padding: 10px 15px; background: #888; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #191a19; }
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
        .data-limite { position: absolute; right: 10; bottom: -2px; font-size: 14px; color: #666; } 
        .btn-lixeira { background: transparent; border: none; cursor: pointer; padding: 0; }
        .btn-lixeira:hover { background: transparent !important; }
        .btn-lixeira i { color: #999; font-size: 18px; opacity: 0.6; }
        .btn-lixeira:hover i{ color: #191a19; opacity: 1; }
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
       
        <form action="/salvar" method="POST" class="form-tarefa">
            @csrf 

            <input type="text" name="nome" placeholder="Digite uma nova tarefa..." required>

           <div class="calendario" onclick="abrirCalendario()">
                <i class="fa-regular fa-calendar"></i>

                <input 
                    type="date" 
                    id="data_limite"
                    name="data_limite"
                >
            </div>

            <button type="submit">
                <i class="fa-solid fa-plus"></i>
            </button>
        </form>

        <br>

        <ul>
            @foreach($tarefas as $tarefa)
               <li class="item-tarefa">    
                    <span 
                        style="
                            flex: 1;
                            min-width: 0;
                            overflow-wrap: break-word;
                            word-break: break-word;
                            {{ $tarefa->concluida ? 'text-decoration: line-through; color: #888;' : '' }}
                        "   
                    >
                        {{ $tarefa->nome }}
                    </span>
                    
                    <div style="display: flex; gap: 5px;">
                        
                        <form action="/concluir/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" title="Marcar como concluída" style="width: 20px; height: 20px; background: transparent ; border: 2px solid #ccc; border-radius: 4px; cursor: pointer; color: #888; display: flex; justify-content: center; align-items: center; position: relative; top: 3px; padding: 0; font-weight: bold;">
                                @if($tarefa->concluida)
                                    <i class="fa-solid fa-check"></i>
                                @endif
                            </button>
                        </form>

                        <form action="/deletar/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" title="Excluir tarefa" class="btn-lixeira">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </form>
                    </div>

                    @if($tarefa->data_limite)
                        <div class="data-limite">
                            {{ \Carbon\Carbon::parse($tarefa->data_limite)->format('d/m') }}
                        </div>
                    @endif

                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>