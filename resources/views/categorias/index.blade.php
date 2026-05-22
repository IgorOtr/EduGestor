@extends('layouts.app')
@section('title', 'Categorias')

@section('content')
<x-page-header title="Categorias">
    <x-slot name="actions">
        <x-btn :href="route('categorias.create')" variant="primary">+ Nova Categoria</x-btn>
    </x-slot>
</x-page-header>

<x-card :padding="false">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Cor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Produtos</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($categorias as $cat)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                              style="background-color: {{ $cat->color }}22; color: {{ $cat->color }}">
                            <span class="w-2 h-2 rounded-full inline-block" style="background-color: {{ $cat->color }}"></span>
                            {{ $cat->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $cat->color }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $cat->produtos_count ?? $cat->produtos->count() }}</td>
                    <td class="px-6 py-4 text-right flex justify-end gap-1">
                        <x-action-btn type="edit" :href="route('categorias.edit', $cat)" title="Editar categoria"/>
                        <x-action-btn type="delete" :href="route('categorias.destroy', $cat)" confirm="Excluir esta categoria?" title="Excluir categoria"/>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">Nenhuma categoria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categorias->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">{{ $categorias->links() }}</div>
    @endif
</x-card>
@endsection
