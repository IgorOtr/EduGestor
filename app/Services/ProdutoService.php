<?php

namespace App\Services;

use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdutoService
{
    public function __construct(private readonly ProdutoRepository $produtoRepository) {}

    public function listar(int $perPage = 15): LengthAwarePaginator
    {
        return $this->produtoRepository->paginate($perPage);
    }

    public function criar(array $data, ?UploadedFile $imagem = null): Produto
    {
        return DB::transaction(function () use ($data, $imagem) {
            if ($imagem) {
                $data['imagem'] = $imagem->store('produtos', 'public');
            }
            return $this->produtoRepository->create($data);
        });
    }

    public function atualizar(Produto $produto, array $data, ?UploadedFile $imagem = null): Produto
    {
        return DB::transaction(function () use ($produto, $data, $imagem) {
            if ($imagem) {
                if ($produto->imagem) {
                    Storage::disk('public')->delete($produto->imagem);
                }
                $data['imagem'] = $imagem->store('produtos', 'public');
            }
            $this->produtoRepository->update($produto, $data);
            return $produto->fresh(['categoria']);
        });
    }

    public function excluir(Produto $produto): void
    {
        DB::transaction(function () use ($produto) {
            if ($produto->imagem) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $this->produtoRepository->delete($produto);
        });
    }

    public function buscarPorId(string $id): Produto
    {
        return $this->produtoRepository->findOrFail($id, ['categoria']);
    }

    public function todos(?string $busca = null, ?string $categoriaId = null)
    {
        return $this->produtoRepository->allAtivos($busca, $categoriaId);
    }
}
