@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<x-page-header title="Dashboard Secretário" description="Acompanhe os indicadores da secretaria"/>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <x-stat-card label="Diretores"        :value="$stats['diretores']"         color="blue"   :route="route('usuarios.diretores')"/>
    <x-stat-card label="Escolas"          :value="$stats['escolas']"           color="green"  :route="route('escolas.index')"/>
    <x-stat-card label="Produtos"         :value="$stats['produtos']"          color="yellow" :route="route('produtos.index')"/>
    <x-stat-card label="Pedidos Pend."    :value="$stats['pedidos_pendentes']" color="red"    :route="route('pedidos.index')"/>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Pedidos Pendentes -->
    <x-card title="Pedidos Pendentes" :padding="false">
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($pedidosPendentes->take(5) as $pedido)
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $pedido->escola->nome ?? '–' }}</p>
                    <p class="text-xs text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <x-status-badge :status="$pedido->status"/>
                    <x-btn :href="route('pedidos.show', $pedido)" variant="outline" size="sm">Analisar</x-btn>
                </div>
            </div>
            @empty
            <p class="px-6 py-6 text-sm text-gray-400 text-center">Nenhum pedido pendente.</p>
            @endforelse
        </div>
        @if($pedidosPendentes->count() > 5)
        <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-700">
            <x-btn :href="route('pedidos.index')" variant="outline" size="sm">Ver todos ({{ $pedidosPendentes->count() }})</x-btn>
        </div>
        @endif
    </x-card>

    <!-- Últimos pedidos -->
    <x-card title="Aprovações Recentes" :padding="false">
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($ultimosPedidos as $pedido)
            <div class="flex items-center justify-between px-6 py-3">
                <div>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $pedido->escola->nome ?? '–' }}</p>
                    <p class="text-xs text-gray-500">{{ $pedido->created_at->diffForHumans() }}</p>
                </div>
                <x-status-badge :status="$pedido->status"/>
            </div>
            @empty
            <p class="px-6 py-6 text-sm text-gray-400 text-center">Nenhum pedido ainda.</p>
            @endforelse
        </div>
    </x-card>
</div>
@endsection
