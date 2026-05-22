<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isRoot() || auth()->user()?->isSecretario();
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:100', Rule::unique('categorias', 'name')->ignore($this->route('categoria'))],
            'color' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
