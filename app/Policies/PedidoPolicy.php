<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Pedido $pedido): bool
    {
        return $user->isRoot()
            || $user->isSecretario()
            || $pedido->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isDiretor();
    }

    public function aprovar(User $user, Pedido $pedido): bool
    {
        return $user->isRoot() || $user->isSecretario();
    }

    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->isRoot();
    }
}
