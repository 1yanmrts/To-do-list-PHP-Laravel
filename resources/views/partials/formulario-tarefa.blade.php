<label>Título *</label>

<input
    type="text"
    name="nome"
    maxlength="128"
    required
    value="{{ $nome ?? '' }}"
    class="input-padrao"
>

<label>Data *</label>

<input
    type="date"
    name="data_limite"
    required
    min="{{ date('Y-m-d') }}"
    value="{{ $data ?? '' }}"
    class="input-padrao"
>

<label>Descrição da tarefa</label>

<textarea
    name="descricao"
    rows="4"
    class="input-padrao"
>{{ $descricao ?? '' }}</textarea>