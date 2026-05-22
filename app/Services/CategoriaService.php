<?php

namespace App\Services;

use App\Models\Categoria;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CategoriaService
{
    public function __construct(private readonly Categoria $categoriaModel) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        return Categoria::latest()->paginate($perPage);
    }

    public function todas(): Collection
    {
        return Categoria::all();
    }

    public function criar(array $data): Categoria
    {
        return DB::transaction(fn () => Categoria::create($data));
    }

    public function atualizar(Categoria $categoria, array $data): Categoria
    {
        return DB::transaction(function () use ($categoria, $data) {
            $categoria->update($data);
            return $categoria->fresh();
        });
    }

    public function excluir(Categoria $categoria): void
    {
        DB::transaction(fn () => $categoria->delete());
    }
}
