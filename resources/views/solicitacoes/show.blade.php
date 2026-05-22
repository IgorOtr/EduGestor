@extends('layouts.app')
@section('title', 'Solicitação de Alteração')

@section('content')
<x-page-header title="Solicitação de Alteração">
    <x-slot name="actions">
        <x-btn :href="route('solicitacoes.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

@php
$labels = [
    'nome' => 'Nome',
    'telefone' => 'Telefone',
    'endereco' => 'Endereço',
    'qnt_masc' => 'Alunos Masculino',
    'qnt_fem' => 'Alunos Feminino',
    'professores' => 'Professores',
    'funcionarios' => 'Funcionários',
];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-5">
        <x-card title="Campos Solicitados">
            <div class="divide-y dark:divide-gray-700">
                @foreach($solicitacao->campos_alterados as $campo => $valorNovo)
                @php
                    // Suporta formato flat ('campo' => 'valor') e antigo ('campo' => ['anterior'=>..,'novo'=>..])
                    $valorExibir = is_array($valorNovo) ? ($valorNovo['novo'] ?? '') : $valorNovo;
                @endphp
                <div class="py-4 grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Campo</p>
                        <p class="font-semibold text-gray-800 dark:text-white">{{ $labels[$campo] ?? $campo }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Valor Atual</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $solicitacao->escola->$campo ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Novo Valor</p>
                        <p class="font-semibold text-blue-600">{{ $valorExibir }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>

        @if($solicitacao->obs_secretario)
        <x-card title="Observação da Secretaria">
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $solicitacao->obs_secretario }}</p>
        </x-card>
        @endif

        @if($solicitacao->status->value === 'pendente' && auth()->user()->isSecretario())
        <x-card title="Avaliar Solicitação">
            <div class="grid grid-cols-2 gap-4">
                <form method="POST" action="{{ route('solicitacoes.aprovar', $solicitacao) }}">
                    @csrf @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Observação (opcional)</label>
                        <textarea name="obs_secretario" rows="3" placeholder="Comentário para o diretor..."
                                  class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 outline-none resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-green-600 text-white rounded-xl text-sm font-semibold hover:bg-green-700 transition">
                        ✅ Aprovar Solicitação
                    </button>
                </form>

                <form method="POST" action="{{ route('solicitacoes.recusar', $solicitacao) }}">
                    @csrf @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Motivo da Recusa *</label>
                        <textarea name="obs_secretario" rows="3" required placeholder="Informe o motivo..."
                                  class="w-full px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-red-500 outline-none resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                        ❌ Recusar Solicitação
                    </button>
                </form>
            </div>
        </x-card>
        @endif
    </div>

    <div class="space-y-5">
        <x-card title="Informações">
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-xs text-gray-400 uppercase tracking-wide">Escola</dt>
                    <dd class="font-semibold text-gray-900 dark:text-white mt-0.5">{{ $solicitacao->escola->nome }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 uppercase tracking-wide">Solicitante</dt>
                    <dd class="text-gray-700 dark:text-gray-300 mt-0.5">{{ $solicitacao->solicitante->nome }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 uppercase tracking-wide">Status</dt>
                    <dd class="mt-1"><x-status-badge :status="$solicitacao->status->value" :label="$solicitacao->status->label()" /></dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-400 uppercase tracking-wide">Data</dt>
                    <dd class="text-gray-700 dark:text-gray-300 mt-0.5">{{ $solicitacao->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                @if($solicitacao->avaliado_em)
                <div>
                    <dt class="text-xs text-gray-400 uppercase tracking-wide">Avaliado em</dt>
                    <dd class="text-gray-700 dark:text-gray-300 mt-0.5">{{ \Carbon\Carbon::parse($solicitacao->avaliado_em)->format('d/m/Y H:i') }}</dd>
                </div>
                @endif
            </dl>
        </x-card>
    </div>
</div>
@endsection
