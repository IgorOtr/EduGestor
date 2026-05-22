@extends('layouts.app')
@section('title', 'Nova Solicitação de Alteração')

@section('content')
<x-page-header title="Solicitar Alteração de Dados Escolares">
    <x-slot name="actions">
        <x-btn :href="route('solicitacoes.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

@php $escola = auth()->user()->escola; @endphp

@if(!$escola)
<x-card>
    <p class="text-gray-500 text-center py-6">Você não está vinculado a nenhuma escola.</p>
</x-card>
@else
<x-card title="Dados Atuais vs. Propostos">
    <p class="text-sm text-gray-500 mb-6">Preencha apenas os campos que deseja alterar. Campos em branco serão ignorados.</p>

    <form method="POST" action="{{ route('solicitacoes.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nome --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Nome Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->nome }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Nome</label>
                <input type="text" name="campos[nome]" value="{{ old('campos.nome') }}" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Telefone --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Telefone Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->telefone ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Telefone</label>
                <input type="text" name="campos[telefone]" value="{{ old('campos.telefone') }}" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Endereço --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Endereço Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->endereco ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Endereço</label>
                <input type="text" name="campos[endereco]" value="{{ old('campos.endereco') }}" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Alunos Masc --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Alunos Masculino Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->qnt_masc ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Qtd. Masculino</label>
                <input type="number" name="campos[qnt_masc]" value="{{ old('campos.qnt_masc') }}" min="0" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Alunos Fem --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Alunos Feminino Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->qnt_fem ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Qtd. Feminino</label>
                <input type="number" name="campos[qnt_fem]" value="{{ old('campos.qnt_fem') }}" min="0" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Professores --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Professores Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->professores ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Nº de Professores</label>
                <input type="number" name="campos[professores]" value="{{ old('campos.professores') }}" min="0" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>

            {{-- Funcionários --}}
            <div>
                <label class="block text-xs text-gray-400 uppercase tracking-wide mb-1">Funcionários Atual</label>
                <p class="px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-sm text-gray-700 dark:text-gray-300">{{ $escola->funcionarios ?? '—' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Novo Nº de Funcionários</label>
                <input type="number" name="campos[funcionarios]" value="{{ old('campos.funcionarios') }}" min="0" placeholder="Deixe em branco para manter"
                       class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"/>
            </div>
        </div>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <ul class="text-sm text-red-600 list-disc list-inside">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="flex justify-end gap-3 pt-2">
            <x-btn :href="route('solicitacoes.index')" variant="secondary">Cancelar</x-btn>
            <x-btn type="submit" variant="primary">Enviar Solicitação</x-btn>
        </div>
    </form>
</x-card>
@endif
@endsection
