@extends('layouts.app')
@section('title', $usuario->nome)

@section('content')
<x-page-header :title="$usuario->nome">
    <x-slot name="actions">
        <x-btn :href="url()->previous(route('usuarios.diretores'))" variant="secondary">← Voltar</x-btn>
        @can('update', $usuario)
        <x-action-btn type="edit" :href="route('usuarios.edit', $usuario)" title="Editar usuário"/>
        @endcan
    </x-slot>
</x-page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card title="Informações Pessoais" class="lg:col-span-2">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Nome</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->nome }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">E-mail</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Matrícula</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->matricula ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Telefone</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->telefone ?? '—' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Endereço</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->endereco ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Perfil</p>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                    {{ $usuario->role === \App\Enums\RoleEnum::Root ? 'bg-purple-100 text-purple-700' : ($usuario->role === \App\Enums\RoleEnum::Secretario ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                    {{ $usuario->role->label() }}
                </span>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Membro desde</p>
                <p class="font-medium text-gray-900 dark:text-white">{{ $usuario->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </x-card>

    <div class="space-y-5">
        @if($usuario->isDiretor() && $usuario->escola)
        <x-card title="Escola Vinculada">
            <a href="{{ route('escolas.show', $usuario->escola) }}" class="flex items-start gap-3 group">
                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center flex-shrink-0 text-lg">🏫</div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 transition">{{ $usuario->escola->nome }}</p>
                    <p class="text-xs text-gray-400">{{ $usuario->escola->endereco }}</p>
                </div>
            </a>
        </x-card>
        @endif

        @can('delete', $usuario)
        <x-card>
            <p class="text-sm font-semibold text-red-600 mb-3">Zona de Perigo</p>
            <x-action-btn type="delete" :href="route('usuarios.destroy', $usuario)" confirm="Tem certeza? Esta ação não pode ser desfeita." title="Excluir usuário" class="w-full justify-center flex"/>
        </x-card>
        @endcan
    </div>
</div>
@endsection
