<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use App\Models\SolicitacaoAlteracao;
use App\Services\SolicitacaoAlteracaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolicitacaoAlteracaoController extends Controller
{
    public function __construct(
        private readonly SolicitacaoAlteracaoService $service,
    ) {}

    public function index(): View
    {
        $solicitacoes = $this->service->listar();
        return view('solicitacoes.index', compact('solicitacoes'));
    }

    public function create(): View
    {
        $escola = auth()->user()->escola;
        abort_unless($escola, 403, 'Você não está vinculado a nenhuma escola.');
        return view('solicitacoes.create', compact('escola'));
    }

    public function store(Request $request): RedirectResponse
    {
        $escola = auth()->user()->escola;
        abort_unless($escola, 403);

        $data = $request->validate([
            'campos.nome'         => ['nullable', 'string', 'max:255'],
            'campos.telefone'     => ['nullable', 'string', 'max:20'],
            'campos.endereco'     => ['nullable', 'string', 'max:500'],
            'campos.qnt_masc'     => ['nullable', 'integer', 'min:0'],
            'campos.qnt_fem'      => ['nullable', 'integer', 'min:0'],
            'campos.professores'  => ['nullable', 'integer', 'min:0'],
            'campos.funcionarios' => ['nullable', 'integer', 'min:0'],
        ]);

        $campos = array_filter($data['campos'] ?? [], fn ($v) => !is_null($v) && $v !== '');

        abort_if(empty($campos), 422, 'Preencha ao menos um campo para alterar.');

        $this->service->criar($escola, $campos, auth()->id());

        return redirect()->route('solicitacoes.index')
            ->with('success', 'Solicitação enviada! Aguarde aprovação do secretário.');
    }

    public function show(SolicitacaoAlteracao $solicitacao): View
    {
        $user = auth()->user();
        if ($user->isDiretor()) {
            abort_unless($solicitacao->user_id === $user->id, 403);
        }
        $solicitacao->load(['escola', 'solicitante', 'avaliador']);
        return view('solicitacoes.show', compact('solicitacao'));
    }

    public function aprovar(Request $request, SolicitacaoAlteracao $solicitacao): RedirectResponse
    {
        $obs = $request->input('obs_secretario');
        $this->service->aprovar($solicitacao, $obs);

        return back()->with('success', 'Solicitação aprovada com sucesso!');
    }

    public function recusar(Request $request, SolicitacaoAlteracao $solicitacao): RedirectResponse
    {
        $obs = $request->input('obs_secretario');
        $this->service->recusar($solicitacao, $obs);

        return back()->with('success', 'Solicitação recusada.');
    }
}
