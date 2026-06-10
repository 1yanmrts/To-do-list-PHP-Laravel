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
        return true; // se eu colocar false, não consigo adicionar nada a lista de tarefas
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $regras = [
            'nome' => 'required|string|max:128',
            'descricao' => 'nullable|string|max:255',
        ];

        // Esse bloco vai servir para verificar se a data da tarefa está sendo aplicada na criação dela
        // (daí o calendário precisa ser restrito apenas para datas a partir do dia atual);
        // ou se o usuário quer editar uma tarefa com data expirada e vai poder escolher se quer ou nao
        // modificar a data
        if ($this->isMethod('post')) {
            $regras['data_limite'] = 'required|date|after_or_equal:today';
        } else {
            $regras['data_limite'] = 'required|date';
        }

        return $regras;
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O título da tarefa é obrigatório.',
            'nome.max' => 'O título não pode ter mais de 128 caracteres.',
            'data_limite.required' => 'A data limite é obrigatória.',
            'data_limite.date' => 'Informe uma data válida.',
            'data_limite.after_or_equal' => 'A data limite não pode estar no passado.',
            'descricao.max' => 'A descrição não pode passar de 255 caracteres.',
        ];
    }
}
