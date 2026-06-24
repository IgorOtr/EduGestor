@extends('layouts.app')
@section('title', $escola->nome)

@section('content')
<x-page-header :title="$escola->nome" description="Detalhes da escola">
    <x-slot name="actions">
        <x-btn :href="route('escolas.index')" variant="secondary">← Voltar</x-btn>
        @can('update', $escola)
        <x-btn :href="route('escolas.edit', $escola)" variant="primary">Editar</x-btn>
        @endcan
        @if(auth()->user()->isDiretor() && $escola->diretor_id === auth()->id())
        <x-btn :href="route('solicitacoes.create', $escola)" variant="outline">Solicitar Alteração</x-btn>
        @endif
    </x-slot>
</x-page-header>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        @if(auth()->user()?->isSecretario() || auth()->user()?->isRoot())
        <x-card title="Custo Mensal da Escola (últimos 12 meses)">
            <div id="chart_custo_mensal" style="min-height: 280px;"></div>
        </x-card>
        @endif
        <x-card title="Dados da Escola">
            <div class="grid grid-cols-2 gap-4 text-sm">
                @foreach([
                    'Nome' => $escola->nome,
                    'Telefone' => $escola->telefone ?? '–',
                    'Endereço' => $escola->endereco ?? '–',
                    'Faixa Etária' => $escola->faixa_etaria ?? '–',
                    'Alunos Masc.' => $escola->qnt_masc,
                    'Alunos Fem.' => $escola->qnt_fem,
                    'Total Alunos' => $escola->qnt_total,
                    'Professores' => $escola->professores,
                    'Funcionários' => $escola->funcionarios,
                    'Diretor' => $escola->diretor->nome ?? 'Sem diretor',
                ] as $label => $valor)
                <div>
                    <p class="text-gray-500 text-xs mb-0.5">{{ $label }}</p>
                    <p class="font-semibold text-gray-800 dark:text-white">{{ $valor }}</p>
                </div>
                @endforeach
            </div>

            @if(auth()->user()?->isSecretario() || auth()->user()?->isRoot())
            <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700">
                <p class="text-gray-500 text-xs mb-0.5">Custo por Aluno (mês atual)</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $escola->custo_por_aluno !== null ? 'R$ ' . number_format((float) $escola->custo_por_aluno, 2, ',', '.') : '–' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Baseado no total aprovado em {{ now()->locale('pt_BR')->translatedFormat('F/Y') }}. Atualizado a cada aprovação de pedido.</p>
            </div>
            @endif
        </x-card>

        <!-- Pedidos da escola -->
        <x-card title="Pedidos" :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pedido</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Data</th>
                            <th class="px-6 py-3 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($escola->pedidos as $pedido)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-6 py-3 text-xs font-mono text-gray-500">{{ substr($pedido->id, 0, 8) }}...</td>
                            <td class="px-6 py-3"><x-status-badge :status="$pedido->status"/></td>
                            <td class="px-6 py-3 text-gray-500 text-xs">{{ $pedido->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-right">
                                <x-btn :href="route('pedidos.show', $pedido)" variant="outline" size="sm">Ver</x-btn>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-6 text-center text-gray-400 text-sm">Nenhum pedido.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        @if(auth()->user()?->isSecretario() || auth()->user()?->isRoot())
        <x-card title="Taxa de Aprovação">
            <div id="chart_taxa_aprovacao" style="min-height: 280px;"></div>
        </x-card>
        @endif
        @can('update', $escola)
        <x-card title="Vincular Diretor">
            <form method="POST" action="{{ route('escolas.vincular-diretor', [$escola, '__DIRETOR__']) }}" id="formVincular">
                @csrf
            </form>
            <p class="text-sm text-gray-500 mb-3">Diretor atual: <strong>{{ $escola->diretor->nome ?? 'nenhum' }}</strong></p>
            <form method="POST" action="" id="formVincularDiretor">
                @csrf
                <select name="diretor_id" id="sltDiretor" onchange="document.getElementById('formVincularDiretor').action='/escolas/{{ $escola->id }}/vincular-diretor/' + this.value"
                        class="w-full px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-sm dark:bg-gray-700 dark:text-white mb-3">
                    <option value="">Selecione...</option>
                    @foreach(\App\Models\User::where('role', \App\Enums\RoleEnum::Diretor)->get() as $d)
                    <option value="{{ $d->id }}" {{ $escola->diretor_id === $d->id ? 'selected' : '' }}>{{ $d->nome }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition">
                    Vincular
                </button>
            </form>
        </x-card>
        @endcan

        @can('delete', $escola)
        <x-card>
            <div x-data="{ open: false }">
                {{-- Botão que abre o popup --}}
                <button type="button" @click="open = true"
                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition">
                    Excluir Escola
                </button>

                {{-- Overlay + popup --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click.self="open = false"
                     class="fixed inset-0 z-50 flex items-center justify-center"
                     style="display:none; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(2px);">
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-6 mx-4"
                         style="width: 30vw; min-width: 280px;">

                        {{-- Ícone de aviso --}}
                        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>

                        <h3 class="text-base font-semibold text-center text-gray-900 dark:text-white mb-1">
                            Confirmar exclusão
                        </h3>
                        <p class="text-sm text-center text-gray-500 dark:text-gray-400 mb-6">
                            Tem certeza que deseja excluir esta escola? Esta ação não poderá ser desfeita.
                        </p>

                        <div class="flex gap-3">
                            <button type="button" @click="open = false"
                                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                                Cancelar
                            </button>
                            <form method="POST" action="{{ route('escolas.destroy', $escola) }}" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full px-4 py-2 text-sm font-medium rounded-lg bg-red-600 hover:bg-red-700 text-white transition shadow-sm">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
        @endcan
    </div>
</div>
@endsection

@if(auth()->user()?->isSecretario() || auth()->user()?->isRoot())
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark  = document.documentElement.classList.contains('dark');
    const labels  = @json($custoMensal->pluck('label'));
    const valores = @json($custoMensal->pluck('total'));
    const taxaAprovacao = @json($taxaAprovacao);
    const taxaValores = [
        taxaAprovacao.percentuais.aprovados,
        taxaAprovacao.percentuais.parciais,
        taxaAprovacao.percentuais.recusados,
    ];

    const options = {
        series: [{ name: 'Custo Total (R$)', data: valores }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false },
            fontFamily: 'inherit',
            foreColor: isDark ? '#9ca3af' : '#6b7280',
        },
        plotOptions: {
            bar: { borderRadius: 6, columnWidth: '55%' }
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: labels,
            labels: { style: { fontSize: '12px' } },
            axisBorder: { show: false },
            axisTicks:  { show: false },
        },
        yaxis: {
            labels: {
                formatter: val => 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2 }),
                style: { fontSize: '12px' },
            }
        },
        tooltip: {
            y: { formatter: val => 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }
        },
        colors: ['#3b82f6'],
        grid: {
            borderColor: isDark ? '#374151' : '#e5e7eb',
            strokeDashArray: 4,
            yaxis: { lines: { show: true } },
        },
        states: {
            hover:  { filter: { type: 'none' } },
            active: { filter: { type: 'none' } },
        },
    };
    new ApexCharts(document.getElementById('chart_custo_mensal'), options).render();

    const taxaElement = document.getElementById('chart_taxa_aprovacao');
    if (taxaElement) {
        const taxaOptions = {
            series: taxaValores,
            chart: {
                type: 'pie',
                height: 280,
                toolbar: { show: false },
                fontFamily: 'inherit',
                foreColor: isDark ? '#9ca3af' : '#6b7280',
            },
            labels: ['Totalmente aprovados', 'Aprovados parcialmente', 'Rejeitados'],
            colors: ['#2563eb', '#9ca3af', '#dc2626'],
            dataLabels: {
                enabled: true,
                formatter: val => val.toLocaleString('pt-BR', { maximumFractionDigits: 1 }) + '%',
            },
            legend: {
                position: 'bottom',
                fontSize: '12px',
                markers: { radius: 12 },
            },
            tooltip: {
                y: {
                    formatter: val => val.toLocaleString('pt-BR', {
                        minimumFractionDigits: 1,
                        maximumFractionDigits: 1,
                    }) + '%',
                },
            },
            stroke: {
                colors: [isDark ? '#1f2937' : '#ffffff'],
            },
            noData: {
                text: 'Nenhum item finalizado',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: isDark ? '#9ca3af' : '#6b7280',
                    fontSize: '13px',
                },
            },
            states: {
                hover:  { filter: { type: 'none' } },
                active: { filter: { type: 'none' } },
            },
        };

        if (taxaAprovacao.total === 0) {
            taxaOptions.series = [];
        }

        new ApexCharts(taxaElement, taxaOptions).render();
    }
});
</script>

@endpush
@endif
