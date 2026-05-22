@extends('layouts.app')
@section('title', 'Editar Escola')

@section('content')
<x-page-header :title="'Editar: ' . $escola->nome">
    <x-slot name="actions">
        <x-btn :href="route('escolas.show', $escola)" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<x-card title="Editar Dados">
    <form method="POST" action="{{ route('escolas.update', $escola) }}" class="space-y-5">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome *</label>
                <input type="text" name="nome" value="{{ old('nome', $escola->nome) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Telefone</label>
                <input type="text" name="telefone" value="{{ old('telefone', $escola->telefone) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Faixa Etária</label>
                <input type="text" name="faixa_etaria" value="{{ old('faixa_etaria', $escola->faixa_etaria) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Endereço</label>
                <input type="text" name="endereco" value="{{ old('endereco', $escola->endereco) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
            @foreach([
                ['qnt_masc', 'Alunos Masculino'],
                ['qnt_fem', 'Alunos Feminino'],
                ['qnt_total', 'Total de Alunos'],
                ['professores', 'Professores'],
                ['funcionarios', 'Funcionários'],
            ] as [$field, $label])
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ $label }}</label>
                <input type="number" name="{{ $field }}" value="{{ old($field, $escola->$field) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white"/>
            </div>
            @endforeach
        </div>
        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('escolas.show', $escola)" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Salvar Alterações</x-btn>
        </div>
    </form>
</x-card>
@endsection
