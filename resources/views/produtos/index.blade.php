@extends('layouts.app')
@section('title', 'Produtos')

@section('content')
<x-page-header title="Produtos">
    <x-slot name="actions">
        @can('create', \App\Models\Produto::class)
        <x-btn :href="route('produtos.create')" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo Produto
        </x-btn>
        @endcan
    </x-slot>
</x-page-header>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($produtos as $produto)
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
        @if($produto->imagem)
        <img src="{{ Storage::url($produto->imagem) }}" alt="{{ $produto->nome }}" class="w-full h-40 object-cover"/>
        @else
        <div class="w-full h-40 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        @endif
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <h3 class="font-semibold text-gray-800 dark:text-white text-sm">{{ $produto->nome }}</h3>
                <span class="ml-2 inline-block px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0"
                      style="background-color: {{ $produto->categoria->color }}22; color: {{ $produto->categoria->color }}">
                    {{ $produto->categoria->name }}
                </span>
            </div>
            @if($produto->descricao)
            <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $produto->descricao }}</p>
            @endif
            <div class="flex items-center justify-between text-xs text-gray-400 mb-3">
                <span>Min: {{ $produto->qnt_min }}</span>
                <span>Max: {{ $produto->qnt_max }}</span>
            </div>
            <div class="flex gap-1 justify-end">
                <x-action-btn type="show" :href="route('produtos.show', $produto)" title="Ver produto"/>
                @can('update', $produto)
                <x-action-btn type="edit" :href="route('produtos.edit', $produto)" title="Editar produto"/>
                @endcan
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center text-gray-400">Nenhum produto cadastrado.</div>
    @endforelse
</div>

@if($produtos->hasPages())
<div class="mt-6">{{ $produtos->links() }}</div>
@endif
@endsection
