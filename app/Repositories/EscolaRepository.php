<?php

namespace App\Repositories;

use App\Models\Escola;
use Illuminate\Pagination\LengthAwarePaginator;

class EscolaRepository extends BaseRepository
{
    public function __construct(Escola $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $perPage = 15, array $relations = []): LengthAwarePaginator
    {
        return Escola::with($relations ?: ['diretor'])->latest()->paginate($perPage);
    }

    public function semDiretor(): \Illuminate\Database\Eloquent\Collection
    {
        return Escola::whereNull('diretor_id')->get();
    }

    public function findByDiretor(string $diretorId): ?Escola
    {
        return Escola::where('diretor_id', $diretorId)->first();
    }
}
