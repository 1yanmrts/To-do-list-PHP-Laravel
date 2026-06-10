<input type="checkbox" 
       style="width: 18px; height: 18px; cursor: pointer;" 
       onchange="alternarStatusTabela({{ $tarefa->id }}, this)" 
       {{ $tarefa->concluida ? 'checked' : '' }}>