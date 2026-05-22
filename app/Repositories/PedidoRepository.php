<?php

namespace App\Repositories;

use App\Enums\PedidoStatusEnum;
use App\Models\Pedido;
use Illuminate\Pagination\LengthAwarePaginator;

class PedidoRepository extends BaseRepository
{
    public function __construct(Pedido $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15, array $relations = [], ?string $userId = null): LengthAwarePaginator
    {
        return Pedido::with($relations ?: ['escola', 'diretor', 'itens.produto'])
            ->when($userId, fn ($q) => $q->where('user_id', $userId))
            ->latest()
            ->paginate($perPage);
    }

    public function pendentes(): \Illuminate\Database\Eloquent\Collection
    {
        return Pedido::with(['escola', 'diretor', 'itens.produto'])
            ->where('status', PedidoStatusEnum::Pendente)
            ->latest()
            ->get();
    }

    public function porEscola(string $escolaId): \Illuminate\Database\Eloquent\Collection
    {
        return Pedido::with(['itens.produto'])
            ->where('escola_id', $escolaId)
            ->latest()
            ->get();
    }

    public function countPendentes(): int
    {
        return Pedido::where('status', PedidoStatusEnum::Pendente)->count();
    }

    public function ultimos(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Pedido::with(['escola', 'diretor'])->latest()->limit($limit)->get();
    }
}
