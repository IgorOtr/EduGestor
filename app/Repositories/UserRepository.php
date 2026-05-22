<?php

namespace App\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function paginateByRole(RoleEnum $role, int $perPage = 15): LengthAwarePaginator
    {
        return User::where('role', $role)->latest()->paginate($perPage);
    }

    public function allDiretores(): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('role', RoleEnum::Diretor)->get();
    }

    public function allSecretarios(): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('role', RoleEnum::Secretario)->get();
    }

    public function countByRole(RoleEnum $role): int
    {
        return User::where('role', $role)->count();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
