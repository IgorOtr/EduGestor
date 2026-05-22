<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isRoot() || $auth->isSecretario();
    }

    public function view(User $auth, User $user): bool
    {
        return $auth->isRoot() || $auth->isSecretario() || $auth->id === $user->id;
    }

    public function create(User $auth): bool
    {
        return $auth->isRoot() || $auth->isSecretario();
    }

    public function update(User $auth, User $user): bool
    {
        return $auth->isRoot() || $auth->id === $user->id;
    }

    public function delete(User $auth, User $user): bool
    {
        return $auth->isRoot() && $auth->id !== $user->id;
    }
}
