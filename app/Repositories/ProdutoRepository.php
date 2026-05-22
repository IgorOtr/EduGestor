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

    public function allAtivos(): \Illuminate\Database\Eloquent\Collection
    {
        return Produto::with('categoria')->get();
    }
}
