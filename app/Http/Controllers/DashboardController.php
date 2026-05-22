<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Repositories\EscolaRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\UserRepository;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly UserRepository  $userRepo,
        private readonly EscolaRepository $escolaRepo,
        private readonly PedidoRepository $pedidoRepo,
    ) {}

    public function index()
    {
        $user = auth()->user();

        if ($user->isRoot()) {
            return $this->dashboardRoot();
        }

        if ($user->isSecretario()) {
            return $this->dashboardSecretario();
        }

        return $this->dashboardDiretor();
    }

    private function dashboardRoot()
    {
        $stats = [
            'diretores'   => $this->userRepo->countByRole(RoleEnum::Diretor),
            'secretarios' => $this->userRepo->countByRole(RoleEnum::Secretario),
            'escolas'     => $this->escolaRepo->count(),
            'produtos'    => Produto::count(),
            'categorias'  => Categoria::count(),
            'pedidos'     => $this->pedidoRepo->count(),
        ];

        $ultimosPedidos = $this->pedidoRepo->ultimos(10);

        return view('dashboard.root', compact('stats', 'ultimosPedidos'));
    }

    private function dashboardSecretario()
    {
        $stats = [
            'diretores'              => $this->userRepo->countByRole(RoleEnum::Diretor),
            'escolas'                => $this->escolaRepo->count(),
            'produtos'               => Produto::count(),
            'pedidos_pendentes'      => $this->pedidoRepo->countPendentes(),
        ];

        $pedidosPendentes  = $this->pedidoRepo->pendentes();
        $ultimosPedidos    = $this->pedidoRepo->ultimos(5);

        return view('dashboard.secretario', compact('stats', 'pedidosPendentes', 'ultimosPedidos'));
    }

    private function dashboardDiretor()
    {
        $user   = auth()->user();
        $escola = $user->escola()->with(['pedidos.itens.produto'])->first();

        $ultimosPedidos = $escola
            ? $this->pedidoRepo->porEscola($escola->id)
            : collect();

        $produtosDisponiveis = Produto::with('categoria')->get();

        return view('dashboard.diretor', compact('user', 'escola', 'ultimosPedidos', 'produtosDisponiveis'));
    }
}
