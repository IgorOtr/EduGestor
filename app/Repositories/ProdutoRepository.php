<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;

class ProdutoRepository extends BaseRepository
{
    public function __construct(Produto $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15, array $relations = []): LengthAwarePaginator
    {
        return Produto::with($relations ?: ['categoria'])->latest()->paginate($perPage);
    }

    public function allAtivos(?string $busca = null, ?string $categoriaId = null): LengthAwarePaginator
    {
        return Produto::with('categoria')
            ->when($busca, fn($q) => $q->where('nome', 'like', "%{$busca}%"))
            ->when($categoriaId, fn($q) => $q->where('categoria_id', $categoriaId))
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }
}
