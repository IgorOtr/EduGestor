<?php

namespace App\Policies;

use App\Models\Produto;
use App\Models\User;

class ProdutoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }

    public function update(User $user, Produto $produto): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }

    public function delete(User $user, Produto $produto): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }
}
