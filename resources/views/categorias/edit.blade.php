@extends('layouts.app')
@section('title', 'Editar Categoria')

@section('content')
<x-page-header :title="'Editar: ' . $categoria->name">
    <x-slot name="actions">
        <x-btn :href="route('categorias.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Editar Categoria" class="max-w-md">
    <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome *</label>
            <input type="text" name="name" value="{{ old('name', $categoria->name) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Cor *</label>
            <div class="flex gap-3">
                <input type="color" value="{{ old('color', $categoria->color) }}"
                       oninput="document.getElementById('colorInput').value = this.value"
                       class="w-12 h-10 rounded-lg border border-gray-200 cursor-pointer"/>
                <input type="text" name="color" id="colorInput" value="{{ old('color', $categoria->color) }}" required
                       class="flex-1 px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm font-mono dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('categorias.index')" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Salvar</x-btn>
        </div>
    </form>
</x-card>
@endsection
