<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isRoot() || auth()->user()->isSecretario());
    }

    public function rules(): array
    {
        return [
            'nome'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', Password::min(8)->mixedCase()->numbers()],
            'role'      => ['required', new Enum(RoleEnum::class)],
            'telefone'  => ['nullable', 'string', 'max:20'],
            'matricula' => ['nullable', 'string', 'max:50', 'unique:users,matricula'],
            'endereco'  => ['nullable', 'string', 'max:500'],
        ];
    }
}
