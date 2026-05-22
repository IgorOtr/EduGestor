<?php

namespace App\Http\Controllers;

use App\DTOs\EscolaDTO;
use App\Http\Requests\StoreEscolaRequest;
use App\Http\Requests\UpdateEscolaRequest;
use App\Models\Escola;
use App\Services\EscolaService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EscolaController extends Controller
{
    public function __construct(
        private readonly EscolaService $escolaService,
        private readonly UserService   $userService,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Escola::class);

        $user = auth()->user();
        if ($user->isDiretor()) {
            $escolas = $user->escola
                ? collect([$user->escola])
                : collect();
        } else {
            $escolas = $this->escolaService->listar();
        }

        return view('escolas.index', compact('escolas'));
    }

    public function create(): View
    {
        $this->authorize('create', Escola::class);
        $diretores = $this->userService->diretores();
        return view('escolas.create', compact('diretores'));
    }

    public function store(StoreEscolaRequest $request): RedirectResponse
    {
        $this->authorize('create', Escola::class);
        $dto = EscolaDTO::fromArray($request->validated());
        $escola = $this->escolaService->criar($dto);

        return redirect()->route('escolas.show', $escola)
            ->with('success', 'Escola criada com sucesso!');
    }

    public function show(Escola $escola): View
    {
        $this->authorize('view', $escola);
        $escola->load(['diretor', 'pedidos.itens.produto']);
        return view('escolas.show', compact('escola'));
    }

    public function edit(Escola $escola): View
    {
        $this->authorize('update', $escola);
        $diretores = $this->userService->diretores();
        return view('escolas.edit', compact('escola', 'diretores'));
    }

    public function update(UpdateEscolaRequest $request, Escola $escola): RedirectResponse
    {
        $this->authorize('update', $escola);
        $dto = EscolaDTO::fromArray($request->validated());
        $this->escolaService->atualizar($escola, $dto);

        return redirect()->route('escolas.show', $escola)
            ->with('success', 'Escola atualizada com sucesso!');
    }

    public function vincularDiretor(Escola $escola, string $diretorId): RedirectResponse
    {
        $this->authorize('update', $escola);
        $this->escolaService->vincularDiretor($escola, $diretorId);

        return back()->with('success', 'Diretor vinculado com sucesso!');
    }

    public function destroy(Escola $escola): RedirectResponse
    {
        $this->authorize('delete', $escola);
        $this->escolaService->excluir($escola);

        return redirect()->route('escolas.index')
            ->with('success', 'Escola removida com sucesso!');
    }
}
