<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEscolaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nome'         => ['required', 'string', 'max:255'],
            'telefone'     => ['nullable', 'string', 'max:20'],
            'endereco'     => ['nullable', 'string', 'max:500'],
            'qnt_masc'     => ['nullable', 'integer', 'min:0'],
            'qnt_fem'      => ['nullable', 'integer', 'min:0'],
            'qnt_total'    => ['nullable', 'integer', 'min:0'],
            'faixa_etaria' => ['nullable', 'string', 'max:100'],
            'professores'  => ['nullable', 'integer', 'min:0'],
            'funcionarios' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
