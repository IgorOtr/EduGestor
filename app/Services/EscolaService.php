<?php

namespace App\Services;

use App\DTOs\EscolaDTO;
use App\Models\Escola;
use App\Repositories\EscolaRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EscolaService
{
    public function __construct(private readonly EscolaRepository $escolaRepository) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        return $this->escolaRepository->paginate($perPage);
    }

    public function criar(EscolaDTO $dto): Escola
    {
        return DB::transaction(fn () => $this->escolaRepository->create($dto->toArray()));
    }

    public function atualizar(Escola $escola, EscolaDTO $dto): Escola
    {
        return DB::transaction(function () use ($escola, $dto) {
            $this->escolaRepository->update($escola, $dto->toArray());
            return $escola->fresh();
        });
    }

    public function vincularDiretor(Escola $escola, string $diretorId): Escola
    {
        return DB::transaction(function () use ($escola, $diretorId) {
            // Desvincular diretor de outras escolas
            Escola::where('diretor_id', $diretorId)
                ->where('id', '!=', $escola->id)
                ->update(['diretor_id' => null]);

            $this->escolaRepository->update($escola, ['diretor_id' => $diretorId]);
            return $escola->fresh(['diretor']);
        });
    }

    public function excluir(Escola $escola): void
    {
        DB::transaction(fn () => $this->escolaRepository->delete($escola));
    }

    public function buscarPorId(string $id): Escola
    {
        return $this->escolaRepository->findOrFail($id, ['diretor']);
    }

    public function semDiretor(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->escolaRepository->semDiretor();
    }
}
