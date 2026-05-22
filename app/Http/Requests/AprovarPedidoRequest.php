<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AprovarPedidoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'itens'             => ['required', 'array'],
            'itens.*.id'        => ['required', 'uuid', 'exists:item_pedidos,id'],
            'itens.*.qnt_aprov' => ['required', 'integer', 'min:0'],
            'obs_secretario'    => ['nullable', 'string', 'max:1000'],
        ];
    }
}
