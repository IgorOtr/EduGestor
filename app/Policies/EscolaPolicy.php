<?php

namespace App\Policies;

use App\Models\Escola;
use App\Models\User;

class EscolaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Escola $escola): bool
    {
        return $user->isRoot() || $user->isSecretario() || $escola->diretor_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }

    public function update(User $user, Escola $escola): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }

    public function delete(User $user, Escola $escola): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }
}
