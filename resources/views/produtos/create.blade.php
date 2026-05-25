@extends('layouts.app')
@section('title', 'Novo Produto')

@section('content')
<x-page-header title="Novo Produto">
    <x-slot name="actions">
        <x-btn :href="route('produtos.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Dados do Produto">
    <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Categoria *</label>
                <select name="categoria_id" required class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Selecione...</option>
                    @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Imagem</label>
                <input type="file" name="imagem" accept="image/*"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descrição</label>
                <textarea name="descricao" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">{{ old('descricao') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Quantidade Mínima *</label>
                <input type="number" name="qnt_min" value="{{ old('qnt_min', 1) }}" min="1" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Quantidade Máxima *</label>
                <input type="number" name="qnt_max" value="{{ old('qnt_max', 100) }}" min="1" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            @if(auth()->user()->isSecretario() || auth()->user()->isRoot())
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Custo Unitário (R$)</label>
                <input type="number" name="unt_cust" value="{{ old('unt_cust') }}" min="0" step="0.01"
                       placeholder="0,00"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            @endif
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('produtos.index')" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Salvar Produto</x-btn>
        </div>
    </form>
</x-card>
@endsection
