@extends('layouts.app')
@section('title', 'Pedidos')

@section('content')
<x-page-header title="Pedidos">
    <x-slot name="actions">
        @can('create', \App\Models\Pedido::class)
        <x-btn :href="route('pedidos.create')" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Pedido
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
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Itens</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Data</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($pedidos as $pedido)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">{{ $pedido->escola->nome ?? '–' }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $pedido->diretor->nome ?? '–' }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $pedido->itens->count() }}</td>
                    <td class="px-6 py-4"><x-status-badge :status="$pedido->status"/></td>
                    <td class="px-6 py-4 text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <x-action-btn type="show" :href="route('pedidos.show', $pedido)" title="Ver pedido"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400">Nenhum pedido encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pedidos->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
        {{ $pedidos->links() }}
    </div>
    @endif
</x-card>
@endsection
