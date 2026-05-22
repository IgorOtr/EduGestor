@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<x-page-header title="Olá, {{ $user->nome }}!" description="Bem-vindo ao painel do diretor"/>

@if($escola)
<!-- Info escola -->
<div class="grid lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2">
        <x-card title="Minha Escola">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Nome</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->nome }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Telefone</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->telefone ?? '–' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Endereço</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->endereco ?? '–' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Total de Alunos</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->qnt_total }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Professores</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->professores }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Funcionários</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $escola->funcionarios }}</p>
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <x-btn :href="route('escolas.show', $escola)" variant="outline" size="sm">Ver Escola</x-btn>
                <x-btn :href="route('solicitacoes.create', $escola)" variant="secondary" size="sm">Solicitar Alteração</x-btn>
            </div>
        </x-card>
    </div>

    <!-- Ações rápidas -->
    <div class="space-y-4">
        <x-card title="Ações Rápidas">
            <div class="space-y-2">
                <x-btn :href="route('pedidos.create')" variant="primary" size="md" class="w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Novo Pedido
                </x-btn>
                <x-btn :href="route('pedidos.index')" variant="outline" size="md" class="w-full justify-center">
                    Ver Meus Pedidos
                </x-btn>
                <x-btn :href="route('produtos.index')" variant="outline" size="md" class="w-full justify-center">
                    Catálogo de Produtos
                </x-btn>
            </div>
        </x-card>
    </div>
</div>

<!-- Histórico de Pedidos -->
<x-card title="Meus Pedidos" :padding="false">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pedido</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Itens</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Data</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($ultimosPedidos as $pedido)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ substr($pedido->id, 0, 8) }}...</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $pedido->itens->count() }} iten(s)</td>
                    <td class="px-6 py-4"><x-status-badge :status="$pedido->status"/></td>
                    <td class="px-6 py-4 text-gray-500">{{ $pedido->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <x-btn :href="route('pedidos.show', $pedido)" variant="outline" size="sm">Ver</x-btn>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Nenhum pedido realizado ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>

@else
<div class="text-center py-16">
    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Você ainda não tem uma escola vinculada</h3>
    <p class="text-gray-500 mt-2 text-sm">Aguarde o secretário vincular sua conta a uma escola.</p>
</div>
@endif
@endsection
