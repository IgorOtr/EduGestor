@extends('layouts.app')
@section('title', 'Detalhes do Pedido')

@section('content')
<x-page-header title="Pedido #{{ substr($pedido->id, 0, 8) }}" :description="'Criado em ' . $pedido->created_at->format('d/m/Y H:i')">
    <x-slot name="actions">
        <x-btn :href="route('pedidos.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">

        <!-- Itens do pedido -->
        <x-card title="Itens Solicitados" :padding="false">
            @if(auth()->user()->isRoot() || auth()->user()->isSecretario())
            @if($pedido->status->value === 'pendente')
            <form method="POST" action="{{ route('pedidos.aprovar', $pedido) }}" id="formAprovar">
                @csrf
            @endif
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Produto</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Qtd. Solicitada</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Qtd. Aprovada</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($pedido->itens as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">{{ $item->produto->nome ?? '–' }}</td>
                            <td class="px-6 py-4 text-center text-gray-600">{{ $item->qnt_solicit }}</td>
                            <td class="px-6 py-4 text-center">
                                @if((auth()->user()->isRoot() || auth()->user()->isSecretario()) && $pedido->status->value === 'pendente')
                                    <input type="hidden" name="itens[{{ $index }}][id]" value="{{ $item->id }}">
                                    <input type="number" name="itens[{{ $index }}][qnt_aprov]"
                                           value="{{ $item->qnt_solicit }}"
                                           min="0" max="{{ $item->qnt_solicit }}"
                                           class="w-20 text-center border border-gray-200 dark:border-gray-600 rounded-lg py-1 text-sm dark:bg-gray-700 dark:text-white"/>
                                @else
                                    <span class="font-semibold {{ $item->qnt_aprov > 0 ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $item->qnt_aprov ?? '–' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center"><x-status-badge :status="$item->status"/></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if((auth()->user()->isRoot() || auth()->user()->isSecretario()) && $pedido->status->value === 'pendente')
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Observação (opcional)</label>
                <textarea name="obs_secretario" rows="2"
                          class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2 text-sm dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none"
                          placeholder="Observações para o diretor..."></textarea>
                <div class="flex gap-2 mt-3">
                    <button type="submit" form="formAprovar"
                            class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition">
                        ✓ Aprovar Pedido
                    </button>
                    </form>

                    <form method="POST" action="{{ route('pedidos.recusar', $pedido) }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Deseja recusar este pedido?')"
                                class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition">
                            ✕ Recusar Pedido
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </x-card>

        <!-- Timeline -->
        <x-card title="Histórico">
            <ol class="relative border-l border-gray-200 dark:border-gray-700 ml-3 space-y-4">
                <li class="ml-6">
                    <span class="absolute -left-2 w-4 h-4 rounded-full bg-blue-600 ring-4 ring-white dark:ring-gray-800 flex items-center justify-center"></span>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">Pedido criado</p>
                    <p class="text-xs text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }} por {{ $pedido->diretor->nome ?? '–' }}</p>
                </li>
                @if($pedido->aprovado_em)
                <li class="ml-6">
                    <span class="absolute -left-2 w-4 h-4 rounded-full bg-{{ $pedido->status->color() }}-500 ring-4 ring-white dark:ring-gray-800"></span>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $pedido->status->label() }}</p>
                    <p class="text-xs text-gray-500">{{ $pedido->aprovado_em->format('d/m/Y H:i') }}</p>
                    @if($pedido->obs_secretario)
                    <p class="text-xs text-gray-400 mt-1 italic">"{{ $pedido->obs_secretario }}"</p>
                    @endif
                </li>
                @endif
            </ol>
        </x-card>
    </div>

    <!-- Sidebar info -->
    <div class="space-y-4">
        <x-card title="Informações">
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-500 text-xs">Status</p>
                    <div class="mt-1"><x-status-badge :status="$pedido->status"/></div>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Escola</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $pedido->escola->nome ?? '–' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Diretor</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $pedido->diretor->nome ?? '–' }}</p>
                </div>
                @if($pedido->aprovado_em)
                <div>
                    <p class="text-gray-500 text-xs">Data de Aprovação</p>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $pedido->aprovado_em->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                @if($pedido->obs_secretario)
                <div>
                    <p class="text-gray-500 text-xs">Observação</p>
                    <p class="text-gray-700 dark:text-gray-300 italic">{{ $pedido->obs_secretario }}</p>
                </div>
                @endif
            </div>
        </x-card>
    </div>
</div>
@endsection
