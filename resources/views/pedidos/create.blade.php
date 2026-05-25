@extends('layouts.app')
@section('title', 'Novo Pedido')

@section('content')
<x-page-header title="Novo Pedido" description="Selecione os produtos que deseja solicitar">
    <x-slot name="actions">
        <x-btn :href="route('pedidos.index')" variant="secondary">← Voltar</x-btn>
    </x-slot>
</x-page-header>

<div x-data="carrinho()" class="grid lg:grid-cols-3 gap-6">
    <!-- Catálogo -->
    <div class="lg:col-span-2">
        <x-card title="Catálogo de Produtos" :padding="false">
            <!-- Filtros (server-side) -->
            <form method="GET" action="{{ route('pedidos.create') }}" class="px-6 pt-4 pb-3 flex gap-3">
                <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por nome..."
                       class="flex-1 px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white"/>
                <select name="categoria_id"
                        class="px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none dark:bg-gray-700 dark:text-white">
                    <option value="">Todas as categorias</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected($categoriaId == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition">
                    Filtrar
                </button>
                @if($busca || $categoriaId)
                <a href="{{ route('pedidos.create') }}"
                   class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-sm font-medium rounded-xl transition">
                    Limpar
                </a>
                @endif
            </form>

            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($produtos as $produto)
                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                    <div class="flex items-center gap-3">
                        @if($produto->imagem)
                        <img src="{{ Storage::url($produto->imagem) }}" alt="{{ $produto->nome }}"
                             class="w-12 h-12 rounded-xl object-cover border border-gray-100"/>
                        @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $produto->nome }}</p>
                            <p class="text-xs text-gray-500">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium"
                                      style="background-color: {{ $produto->categoria->color }}22; color: {{ $produto->categoria->color }}">
                                    {{ $produto->categoria->name }}
                                </span>
                                &nbsp;Min: {{ $produto->qnt_min }} / Max: {{ $produto->qnt_max }}
                            </p>
                        </div>
                    </div>
                    <button type="button" @click="adicionar('{{ $produto->id }}', '{{ addslashes($produto->nome) }}', {{ (int)$produto->qnt_min }}, {{ (int)$produto->qnt_max }})"
                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition">
                        + Adicionar
                    </button>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-gray-400">
                    Nenhum produto encontrado.
                </div>
                @endforelse
            </div>

            {{-- Paginação --}}
            @if($produtos->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $produtos->links() }}
            </div>
            @endif
        </x-card>
    </div>

    <!-- Carrinho -->
    <div>
        <form method="POST" action="{{ route('pedidos.store') }}" x-ref="form" @submit="submeter($event)"
              id="form-pedido">
            @csrf
            <input type="hidden" name="escola_id" value="{{ $escola->id }}">

            <x-card title="Carrinho">
                <div x-show="itens.length === 0" class="py-8 text-center text-gray-400 text-sm">
                    Nenhum item adicionado.
                </div>

                <div class="space-y-3" x-show="itens.length > 0">
                    <template x-for="(item, index) in itens" :key="item.produto_id">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate" x-text="item.nome"></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <button type="button" @click="decrementar(index)"
                                            class="w-6 h-6 rounded-lg bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold hover:bg-gray-300">−</button>
                                    <input type="number" x-model.number="item.qnt"
                                           :min="item.qnt_min" :max="item.qnt_max"
                                           class="w-14 text-center text-sm border border-gray-200 dark:border-gray-600 rounded-lg py-0.5 dark:bg-gray-700 dark:text-white"/>
                                    <button type="button" @click="incrementar(index)"
                                            class="w-6 h-6 rounded-lg bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-xs font-bold hover:bg-gray-300">+</button>
                                </div>
                                <input type="hidden" :name="`itens[${index}][produto_id]`" :value="item.produto_id">
                                <input type="hidden" :name="`itens[${index}][qnt_solicit]`" :value="item.qnt">
                            </div>
                            <button type="button" @click="remover(index)" class="text-red-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700" x-show="itens.length > 0">
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                        Enviar Pedido (<span x-text="itens.length"></span> iten(s))
                    </button>
                </div>
            </x-card>
        </form>
    </div>
</div>

@push('scripts')
<script>
function carrinho() {
    const STORAGE_KEY = 'carrinho_escola_{{ $escola->id }}';

    return {
        itens: [],

        init() {
            const salvo = localStorage.getItem(STORAGE_KEY);
            if (salvo) {
                try { this.itens = JSON.parse(salvo); } catch (e) { this.itens = []; }
            }

            this.$watch('itens', (valor) => {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(valor));
            }, { deep: true });
        },

        adicionar(id, nome, min, max) {
            const existe = this.itens.find(i => i.produto_id === id);
            if (existe) {
                existe.qnt = Math.min(existe.qnt + 1, max);
                return;
            }
            this.itens.push({ produto_id: id, nome, qnt: min, qnt_min: min, qnt_max: max });
        },

        remover(index) { this.itens.splice(index, 1); },

        incrementar(index) {
            const item = this.itens[index];
            item.qnt = Math.min(item.qnt + 1, item.qnt_max);
        },

        decrementar(index) {
            const item = this.itens[index];
            item.qnt = Math.max(item.qnt - 1, item.qnt_min);
        },

        submeter(e) {
            if (this.itens.length === 0) {
                e.preventDefault();
                alert('Adicione ao menos um item ao carrinho.');
                return;
            }
            // Limpa o storage após enviar com sucesso
            localStorage.removeItem(STORAGE_KEY);
        }
    }
}
</script>
@endpush
@endsection
