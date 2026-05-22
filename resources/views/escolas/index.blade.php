@extends('layouts.app')
@section('title', 'Escolas')

@section('content')
<x-page-header title="Escolas">
    <x-slot name="actions">
        @can('create', \App\Models\Escola::class)
        <x-btn :href="route('escolas.create')" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nova Escola
        </x-btn>
        @endcan
    </x-slot>
</x-page-header>

<x-card :padding="false">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Escola</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Diretor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Telefone</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Alunos</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($escolas as $escola)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">{{ $escola->nome }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                        {{ $escola->diretor->nome ?? '–' }}
                        @if(!$escola->diretor_id)
                        <span class="ml-1 text-xs text-yellow-600 font-medium">(sem diretor)</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $escola->telefone ?? '–' }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $escola->qnt_total }}</td>
                    <td class="px-6 py-4 text-right flex justify-end gap-1">
                        <x-action-btn type="show" :href="route('escolas.show', $escola)" title="Ver escola"/>
                        @can('update', $escola)
                        <x-action-btn type="edit" :href="route('escolas.edit', $escola)" title="Editar escola"/>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Nenhuma escola cadastrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($escolas->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">{{ $escolas->links() }}</div>
    @endif
</x-card>
@endsection
