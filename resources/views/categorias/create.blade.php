@extends('layouts.app')
@section('title', 'Nova Categoria')

@section('content')
<x-page-header title="Nova Categoria">
    <x-slot name="actions">
        <x-btn :href="route('categorias.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Dados da Categoria" class="max-w-md">
    <form method="POST" action="{{ route('categorias.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Cor (HEX) *</label>
            <div class="flex gap-3">
                <input type="color" name="color_picker" value="{{ old('color', '#3b82f6') }}"
                       oninput="document.getElementById('colorInput').value = this.value"
                       class="w-12 h-10 rounded-lg border border-gray-200 cursor-pointer"/>
                <input type="text" name="color" id="colorInput" value="{{ old('color', '#3b82f6') }}" required
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
