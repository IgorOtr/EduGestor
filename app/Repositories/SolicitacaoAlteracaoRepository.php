<?php

namespace App\Repositories;

use App\Models\SolicitacaoAlteracao;
use App\Enums\SolicitacaoStatusEnum;
use Illuminate\Pagination\LengthAwarePaginator;

class SolicitacaoAlteracaoRepository extends BaseRepository
{
    public function __construct(SolicitacaoAlteracao $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15, array $relations = [], ?string $userId = null): LengthAwarePaginator
    {
        return SolicitacaoAlteracao::with($relations ?: ['escola', 'solicitante'])
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->latest()
            ->paginate($perPage);
    }

    public function pendentes(): \Illuminate\Database\Eloquent\Collection
    {
        return SolicitacaoAlteracao::with(['escola', 'solicitante'])
            ->where('status', SolicitacaoStatusEnum::Pendente)
            ->latest()
            ->get();
    }

    public function countPendentes(): int
    {
        return SolicitacaoAlteracao::where('status', SolicitacaoStatusEnum::Pendente)->count();
    }
}
