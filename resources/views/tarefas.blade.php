<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Tarefas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f9; }
        .container { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;}
        input[type="text"] { width: 70%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: left; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert ul { margin: 0; padding-left: 20px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif   
    </div>

    <div class="container">
        <h1>Lista de Tarefas</h1>

        <form action="/salvar" method="POST">
            @csrf <input type="text" name="nome" placeholder="Digite uma nova tarefa..." required>
            <button type="submit">Adicionar</button>
        </form>

        <br>

        <ul>
            @foreach($tarefas as $tarefa)
               <li style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    
                    <span style="{{ $tarefa->concluida ? 'text-decoration: line-through; color: #888;' : '' }}">
                        {{ $tarefa->nome }}
                    </span>
                    
                    <div style="display: flex; gap: 5px;">
                        
                        <form action="/concluir/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: {{ $tarefa->concluida ? '#ffc107' : '#28a745' }}; color: {{ $tarefa->concluida ? '#000' : '#fff' }}; padding: 5px 10px;">
                                {{ $tarefa->concluida ? 'Desfazer' : 'Concluir' }}
                            </button>
                        </form>

                        <form action="/deletar/{{ $tarefa->id }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; padding: 5px 10px;">Excluir</button>
                        </form>

                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</body>
</html>