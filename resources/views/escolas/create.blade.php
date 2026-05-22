@extends('layouts.app')
@section('title', 'Nova Escola')

@section('content')
<x-page-header title="Nova Escola">
    <x-slot name="actions">
        <x-btn :href="route('escolas.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Dados da Escola">
    <form method="POST" action="{{ route('escolas.store') }}" class="space-y-5">
        @csrf
        <div class="grid md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome da Escola *</label>
                <input type="text" name="nome" value="{{ old('nome') }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Diretor</label>
                <select name="diretor_id" class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="">Sem Diretor</option>
                    @foreach($diretores as $diretor)
                    <option value="{{ $diretor->id }}" {{ old('diretor_id') == $diretor->id ? 'selected' : '' }}>{{ $diretor->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white"/>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alunos Masculino</label>
                <input type="number" name="qnt_masc" value="{{ old('qnt_masc', 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alunos Feminino</label>
                <input type="number" name="qnt_fem" value="{{ old('qnt_fem', 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Total de Alunos</label>
                <input type="number" name="qnt_total" value="{{ old('qnt_total', 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Faixa Etária</label>
                <input type="text" name="faixa_etaria" value="{{ old('faixa_etaria') }}" placeholder="Ex: 6 a 14 anos"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Professores</label>
                <input type="number" name="professores" value="{{ old('professores', 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Funcionários</label>
                <input type="number" name="funcionarios" value="{{ old('funcionarios', 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('escolas.index')" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Salvar Escola</x-btn>
        </div>
    </form>
</x-card>
@endsection
