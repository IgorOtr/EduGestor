<?php

namespace App\Http\Controllers;

use App\DTOs\EscolaDTO;
use App\Http\Requests\StoreEscolaRequest;
use App\Http\Requests\UpdateEscolaRequest;
use App\Enums\ItemPedidoStatusEnum;
use App\Models\Escola;
use App\Enums\PedidoStatusEnum;
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

        /** @var \App\Models\User $user */
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

        $custoMensal = collect();
        $taxaAprovacao = [
            'total' => 0,
            'percentuais' => [
                'aprovados' => 0,
                'parciais'  => 0,
                'recusados' => 0,
            ],
        ];

        /** @var \App\Models\User $authUser */
        $authUser = auth()->user();

        if ($authUser?->isSecretario() || $authUser?->isRoot()) {
            $itens = $escola->pedidos->flatMap->itens;
            $totais = [
                'aprovados' => $itens->where('status', ItemPedidoStatusEnum::Aprovado)->count(),
                'parciais'  => $itens->where('status', ItemPedidoStatusEnum::Parcial)->count(),
                'recusados' => $itens->where('status', ItemPedidoStatusEnum::Recusado)->count(),
            ];

            $totalItensFinalizados = array_sum($totais);
            $taxaAprovacao = [
                'total' => $totalItensFinalizados,
                'percentuais' => [
                    'aprovados' => $totalItensFinalizados > 0 ? round(($totais['aprovados'] / $totalItensFinalizados) * 100, 1) : 0,
                    'parciais'  => $totalItensFinalizados > 0 ? round(($totais['parciais'] / $totalItensFinalizados) * 100, 1) : 0,
                    'recusados' => $totalItensFinalizados > 0 ? round(($totais['recusados'] / $totalItensFinalizados) * 100, 1) : 0,
                ],
            ];

            $meses = collect(range(11, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));

            $pedidosAprovados = $escola->pedidos()
                ->whereIn('status', [
                    PedidoStatusEnum::Aprovado->value,
                    PedidoStatusEnum::ParcialmenteAprovado->value,
                ])
                ->whereNotNull('total_cust')
                ->whereNotNull('aprovado_em')
                ->where('aprovado_em', '>=', now()->startOfMonth()->subMonths(11))
                ->get(['total_cust', 'aprovado_em']);

            $custoMensal = $meses->map(function ($mes) use ($pedidosAprovados) {
                $total = $pedidosAprovados
                    ->filter(fn ($p) => $p->aprovado_em->format('Y-m') === $mes->format('Y-m'))
                    ->sum('total_cust');

                return [
                    'label' => $mes->locale('pt_BR')->translatedFormat('M/y'),
                    'total' => round((float) $total, 2),
                ];
            });
        }

        return view('escolas.show', compact('escola', 'custoMensal', 'taxaAprovacao'));
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
