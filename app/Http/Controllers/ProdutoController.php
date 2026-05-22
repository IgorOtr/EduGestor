<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdutoRequest;
use App\Models\Produto;
use App\Services\CategoriaService;
use App\Services\ProdutoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProdutoController extends Controller
{
    public function __construct(
        private readonly ProdutoService  $produtoService,
        private readonly CategoriaService $categoriaService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Produto::class);
        $produtos = $this->produtoService->listar();
        return view('produtos.index', compact('produtos'));
    }

    public function create(): View
    {
        $this->authorize('create', Produto::class);
        $categorias = $this->categoriaService->todas();
        return view('produtos.create', compact('categorias'));
    }

    public function store(StoreProdutoRequest $request): RedirectResponse
    {
        $this->authorize('create', Produto::class);
        $data    = $request->except('imagem');
        $imagem  = $request->file('imagem');
        $produto = $this->produtoService->criar($data, $imagem);

        return redirect()->route('produtos.show', $produto)
            ->with('success', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto): View
    {
        $produto->load('categoria');
        return view('produtos.show', compact('produto'));
    }

    public function edit(Produto $produto): View
    {
        $this->authorize('update', $produto);
        $categorias = $this->categoriaService->todas();
        return view('produtos.edit', compact('produto', 'categorias'));
    }

    public function update(StoreProdutoRequest $request, Produto $produto): RedirectResponse
    {
        $this->authorize('update', $produto);
        $data   = $request->except('imagem');
        $imagem = $request->file('imagem');
        $this->produtoService->atualizar($produto, $data, $imagem);

        return redirect()->route('produtos.show', $produto)
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto): RedirectResponse
    {
        $this->authorize('delete', $produto);
        $this->produtoService->excluir($produto);

        return redirect()->route('produtos.index')
            ->with('success', 'Produto removido com sucesso!');
    }
}
