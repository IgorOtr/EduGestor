@extends('layouts.app')
@section('title', 'Editar Usuário')

@section('content')
<x-page-header :title="'Editar: ' . $usuario->nome">
    <x-slot name="actions">
        <x-btn :href="route('usuarios.show', $usuario)" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Dados do Usuário" class="max-w-2xl">
    <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome Completo *</label>
                <input type="text" name="nome" value="{{ old('nome', $usuario->nome) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">E-mail *</label>
                <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula', $usuario->matricula) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone', $usuario->telefone) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Perfil *</label>
                <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach(\App\Enums\RoleEnum::cases() as $role)
                        @if(auth()->user()->isRoot() || $role !== \App\Enums\RoleEnum::Root)
                        <option value="{{ $role->value }}" {{ old('role', $usuario->role->value) === $role->value ? 'selected' : '' }}>
                            {{ $role->label() }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco', $usuario->endereco) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nova Senha <span class="text-gray-400 text-xs">(deixe em branco para manter)</span></label>
                <input type="password" name="password"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirmar Nova Senha</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('usuarios.show', $usuario)" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Salvar Alterações</x-btn>
        </div>
    </form>
</x-card>
@endsection
