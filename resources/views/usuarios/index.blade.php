@extends('layouts.app')
@section('title', 'Usuários')

@section('content')
<x-page-header title="Usuários do Sistema">
    <x-slot name="actions">
        @can('create', App\Models\User::class)
        <x-btn :href="route('usuarios.create', ['role' => $role->value])" variant="primary">+ Novo {{ $role->label() }}</x-btn>
        @endcan
    </x-slot>
</x-page-header>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Nome</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">E-mail</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Matrícula</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Perfil</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($usuarios as $usuario)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $usuario->nome }}</td>
                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">{{ $usuario->email }}</td>
                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">{{ $usuario->matricula ?? '—' }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $usuario->role === \App\Enums\RoleEnum::Root ? 'bg-purple-100 text-purple-700' : ($usuario->role === \App\Enums\RoleEnum::Secretario ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            {{ $usuario->role->label() }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex gap-1">
                            <x-action-btn type="show" :href="route('usuarios.show', $usuario)" title="Ver usuário"/>
                            @can('update', $usuario)
                            <x-action-btn type="edit" :href="route('usuarios.edit', $usuario)" title="Editar usuário"/>
                            @endcan
                            @can('delete', $usuario)
                            <x-action-btn type="delete" :href="route('usuarios.destroy', $usuario)" confirm="Excluir este usuário?" title="Excluir usuário"/>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-400">Nenhum usuário encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $usuarios->links() }}</div>
</x-card>
@endsection
