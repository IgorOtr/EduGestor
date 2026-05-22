@extends('layouts.app')
@section('title', 'Solicitações de Alteração')

@section('content')
<x-page-header title="Solicitações de Alteração">
    <x-slot name="actions">
        @if(auth()->user()->isDiretor() && auth()->user()->escola)
        <x-btn :href="route('solicitacoes.create')" variant="primary">+ Nova Solicitação</x-btn>
        @endif
    </x-slot>
</x-page-header>

<x-card>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Escola</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Solicitante</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Campos</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Status</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Data</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-600 dark:text-gray-400">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($solicitacoes as $sol)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $sol->escola->nome }}</td>
                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">{{ $sol->solicitante->nome }}</td>
                    <td class="py-3 px-4 text-gray-600 dark:text-gray-400">
                        {{ count($sol->campos_alterados) }} campo(s)
                    </td>
                    <td class="py-3 px-4">
                        <x-status-badge :status="$sol->status->value" :label="$sol->status->label()" />
                    </td>
                    <td class="py-3 px-4 text-gray-500 text-xs">{{ $sol->created_at->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">
                        <x-action-btn type="show" :href="route('solicitacoes.show', $sol)" title="Ver detalhes"/>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-gray-400">Nenhuma solicitação encontrada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $solicitacoes->links() }}</div>
</x-card>
@endsection
