<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function listarPorRole(RoleEnum $role, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->paginateByRole($role, $perPage);
    }

    public function criar(UserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();
            $data['created_by'] = auth()->id();
            return $this->userRepository->create($data);
        });
    }

    public function atualizar(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            unset($data['password'], $data['role']); // Não permitir alteração de role/senha aqui
            $this->userRepository->update($user, $data);
            return $user->fresh();
        });
    }

    public function alterarSenha(User $user, string $novaSenha): void
    {
        $this->userRepository->update($user, ['password' => $novaSenha]);
    }

    public function excluir(User $user): void
    {
        DB::transaction(fn () => $this->userRepository->delete($user));
    }

    public function buscarPorId(string $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function diretores(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->allDiretores();
    }

    public function secretarios(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->userRepository->allSecretarios();
    }
}
