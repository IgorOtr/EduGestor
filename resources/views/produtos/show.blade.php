@extends('layouts.app')
@section('title', $produto->nome)

@section('content')
<x-page-header :title="$produto->nome">
    <x-slot name="actions">
        <x-btn :href="route('produtos.index')" variant="secondary">← Voltar</x-btn>
        @can('update', $produto)
        <x-action-btn type="edit" :href="route('produtos.edit', $produto)" title="Editar produto"/>
        @endcan
        @can('delete', $produto)
        <x-action-btn type="delete" :href="route('produtos.destroy', $produto)" confirm="Excluir este produto?" title="Excluir produto"/>
        @endcan
    </x-slot>
</x-page-header>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card>
            <div class="flex gap-6">
                @if($produto->imagem)
                <img src="{{ Storage::url($produto->imagem) }}" alt="{{ $produto->nome }}" class="w-32 h-32 object-cover rounded-xl border"/>
                @else
                <div class="w-32 h-32 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $produto->nome }}</h2>
                    <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold"
                          style="background-color: {{ $produto->categoria->color }}22; color: {{ $produto->categoria->color }}">
                        {{ $produto->categoria->name }}
                    </span>
                    @if($produto->descricao)
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">{{ $produto->descricao }}</p>
                    @endif
                    <div class="flex gap-6 mt-4 text-sm">
                        <div><span class="text-gray-500">Mín:</span> <strong>{{ $produto->qnt_min }}</strong></div>
                        <div><span class="text-gray-500">Máx:</span> <strong>{{ $produto->qnt_max }}</strong></div>
                        @if(auth()->user()->isSecretario() && $produto->unt_cust !== null)
                        <div><span class="text-gray-500">Custo unit.:</span> <strong>R$ {{ number_format($produto->unt_cust, 2, ',', '.') }}</strong></div>
                        @endif
                    </div>
                </div>
            </div>
        </x-card>
    </div>

    @can('delete', $produto)
    <div>
        {{-- Zona de perigo removida pois o botão excluir foi movido para o header --}}
    </div>
    @endcan
</div>
@endsection
