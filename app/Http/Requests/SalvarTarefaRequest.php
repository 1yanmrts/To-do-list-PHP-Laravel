<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalvarTarefaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;//se eu colocar false, não consigo adicionar nada a lista de tarefas
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //nome é obrigatório, é string e tem no máximo 128 caracteres
            'nome' => 'required|string|max:128',
            'data_limite' => 'required|date',
            'descricao' => 'nullable|string|max:255',
        ];
    }
}