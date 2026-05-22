<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = $this->route('usuario') ?? $this->route('user');
        $id     = is_object($userId) ? $userId->id : $userId;

        return [
            'nome'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', "unique:users,email,{$id}"],
            'telefone' => ['nullable', 'string', 'max:20'],
            'matricula'=> ['nullable', 'string', 'max:50', "unique:users,matricula,{$id}"],
            'endereco' => ['nullable', 'string', 'max:500'],
        ];
    }
}
