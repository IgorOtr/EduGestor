<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'nome'         => ['required', 'string', 'max:255'],
            'descricao'    => ['nullable', 'string'],
            'categoria_id' => ['required', 'uuid', 'exists:categorias,id'],
            'imagem'       => ['nullable', 'image', 'max:2048'],
            'qnt_min'      => ['required', 'integer', 'min:1'],
            'qnt_max'      => ['required', 'integer', 'min:1', 'gte:qnt_min'],
        ];
    }
}
