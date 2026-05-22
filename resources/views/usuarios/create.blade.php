@extends('layouts.app')
@section('title', 'Novo Usuário')

@section('content')
<x-page-header title="Novo Usuário">
    <x-slot name="actions">
        <x-btn :href="url()->previous(route('usuarios.diretores'))" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Dados do Usuário" class="max-w-2xl">
    <form method="POST" action="{{ route('usuarios.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome Completo *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">E-mail *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Perfil *</label>
                <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Selecione...</option>
                    @foreach(\App\Enums\RoleEnum::cases() as $r)
                        @if(auth()->user()->isRoot() || $r !== \App\Enums\RoleEnum::Root)
                        <option value="{{ $r->value }}" {{ old('role', $role?->value) === $r->value ? 'selected' : '' }}>
                            {{ $r->label() }}
                        </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Senha *</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirmar Senha *</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="url()->previous(route('usuarios.diretores'))" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Criar Usuário</x-btn>
        </div>
    </form>
</x-card>
@endsection
