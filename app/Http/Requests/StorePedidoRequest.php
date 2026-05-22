<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'escola_id'              => ['required', 'uuid', 'exists:escolas,id'],
            'itens'                  => ['required', 'array', 'min:1'],
            'itens.*.produto_id'     => ['required', 'uuid', 'exists:produtos,id'],
            'itens.*.qnt_solicit'    => ['required', 'integer', 'min:1'],
        ];
    }
}
