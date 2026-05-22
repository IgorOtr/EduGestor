<?php

namespace App\Services;

use App\Enums\SolicitacaoStatusEnum;
use App\Models\Escola;
use App\Models\SolicitacaoAlteracao;
use App\Repositories\SolicitacaoAlteracaoRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SolicitacaoAlteracaoService
{
    public function __construct(
        private readonly SolicitacaoAlteracaoRepository $repo,
        private readonly EscolaService $escolaService,
    ) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        $user   = auth()->user();
        $userId = $user->isDiretor() ? $user->id : null;
        return $this->repo->paginate($perPage, [], $userId);
    }

    public function criar(Escola $escola, array $novosDados, string $userId): SolicitacaoAlteracao
    {
        return DB::transaction(function () use ($escola, $novosDados, $userId) {
            // Salva apenas campos que realmente mudaram, com valor novo simples
            $camposAlterados = [];
            foreach ($novosDados as $campo => $valor) {
                if ((string) $escola->$campo !== (string) $valor) {
                    $camposAlterados[$campo] = $valor;
                }
            }

            abort_if(empty($camposAlterados), 422, 'Nenhuma alteração detectada.');

            return SolicitacaoAlteracao::create([
                'escola_id'        => $escola->id,
                'user_id'          => $userId,
                'campos_alterados' => $camposAlterados,
                'status'           => SolicitacaoStatusEnum::Pendente,
            ]);
        });
    }

    public function aprovar(SolicitacaoAlteracao $solicitacao, ?string $obs = null): SolicitacaoAlteracao
    {
        return DB::transaction(function () use ($solicitacao, $obs) {
            // Suporta formato flat e formato antigo ['anterior'=>..,'novo'=>..]
            $dados = collect($solicitacao->campos_alterados)
                ->mapWithKeys(fn ($val, $key) => [$key => is_array($val) ? $val['novo'] : $val])
                ->toArray();

            $solicitacao->escola->update($dados);

            $solicitacao->update([
                'status'         => SolicitacaoStatusEnum::Aprovado,
                'obs_secretario' => $obs,
                'avaliado_em'    => now(),
                'avaliado_por'   => auth()->id(),
            ]);

            return $solicitacao->fresh();
        });
    }

    public function recusar(SolicitacaoAlteracao $solicitacao, ?string $obs = null): SolicitacaoAlteracao
    {
        return DB::transaction(function () use ($solicitacao, $obs) {
            $solicitacao->update([
                'status'         => SolicitacaoStatusEnum::Recusado,
                'obs_secretario' => $obs,
                'avaliado_em'    => now(),
                'avaliado_por'   => auth()->id(),
            ]);
            return $solicitacao->fresh();
        });
    }

    public function pendentes(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repo->pendentes();
    }

    public function buscarPorId(string $id): SolicitacaoAlteracao
    {
        return $this->repo->findOrFail($id, ['escola', 'solicitante', 'avaliador']);
    }
}
