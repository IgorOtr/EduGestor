<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function __construct(private readonly CategoriaService $categoriaService) {}

    public function index(): View
    {
        $categorias = $this->categoriaService->listar();
        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $this->categoriaService->criar($request->validated());
        return redirect()->route('categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(\App\Http\Requests\UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $this->categoriaService->atualizar($categoria, $request->validated());
        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $this->categoriaService->excluir($categoria);
        return redirect()->route('categorias.index')
            ->with('success', 'Categoria removida com sucesso!');
    }
}
