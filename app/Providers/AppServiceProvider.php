<?php

namespace App\Providers;

use App\Models\Escola;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\User;
use App\Policies\EscolaPolicy;
use App\Policies\PedidoPolicy;
use App\Policies\ProdutoPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(User::class,   UserPolicy::class);
        Gate::policy(Escola::class, EscolaPolicy::class);
        Gate::policy(Pedido::class, PedidoPolicy::class);
        Gate::policy(Produto::class, ProdutoPolicy::class);
    }
}
