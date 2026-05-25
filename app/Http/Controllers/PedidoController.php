<?php

namespace App\Http\Controllers;

use App\DTOs\PedidoDTO;
use App\Http\Requests\AprovarPedidoRequest;
use App\Http\Requests\StorePedidoRequest;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Services\PedidoService;
use App\Services\ProdutoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function __construct(
        private readonly PedidoService  $pedidoService,
        private readonly ProdutoService $produtoService,
    ) {}

    public function index(): View
    {
        $pedidos = $this->pedidoService->listar();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create(): View
    {
        $this->authorize('create', Pedido::class);
        $busca      = request('busca');
        $categoriaId = request('categoria_id');
        $produtos   = $this->produtoService->todos($busca, $categoriaId);
        $categorias = Categoria::orderBy('name')->get();
        $escola     = auth()->user()->escola;
        return view('pedidos.create', compact('produtos', 'escola', 'categorias', 'busca', 'categoriaId'));
    }

    public function store(StorePedidoRequest $request): RedirectResponse
    {
        $this->authorize('create', Pedido::class);
        $dto    = PedidoDTO::fromArray($request->validated(), auth()->id());
        $pedido = $this->pedidoService->criar($dto);

        return redirect()->route('pedidos.show', $pedido)
            ->with('success', 'Pedido realizado com sucesso!');
    }

    public function show(Pedido $pedido): View
    {
        $this->authorize('view', $pedido);
        $pedido->load(['itens.produto', 'escola', 'diretor']);
        return view('pedidos.show', compact('pedido'));
    }

    public function aprovar(AprovarPedidoRequest $request, Pedido $pedido): RedirectResponse
    {
        $this->authorize('aprovar', $pedido);
        $this->pedidoService->aprovar(
            $pedido,
            $request->input('itens'),
            $request->input('obs_secretario'),
        );

        return back()->with('success', 'Pedido processado com sucesso!');
    }

    public function recusar(Pedido $pedido): RedirectResponse
    {
        $this->authorize('aprovar', $pedido);
        $obs = request()->input('obs_secretario');
        $this->pedidoService->recusar($pedido, $obs);

        return back()->with('success', 'Pedido recusado.');
    }

    public function destroy(Pedido $pedido): RedirectResponse
    {
        $this->authorize('delete', $pedido);
        $pedido->delete();

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido removido com sucesso!');
    }
}
