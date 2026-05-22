<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EscolaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\SolicitacaoAlteracaoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// Autenticação padrão Laravel
require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Usuários - Diretores
    Route::prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/diretores', [UsuarioController::class, 'indexDiretores'])->name('diretores');
        Route::get('/secretarios', [UsuarioController::class, 'indexSecretarios'])->name('secretarios');
        Route::get('/criar', [UsuarioController::class, 'create'])->name('create');
        Route::post('/', [UsuarioController::class, 'store'])->name('store');
        Route::get('/{usuario}', [UsuarioController::class, 'show'])->name('show');
        Route::get('/{usuario}/editar', [UsuarioController::class, 'edit'])->name('edit');
        Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('update');
        Route::delete('/{usuario}', [UsuarioController::class, 'destroy'])->name('destroy');
    });

    // Escolas
    Route::resource('escolas', EscolaController::class);
    Route::post('/escolas/{escola}/vincular-diretor/{diretorId}', [EscolaController::class, 'vincularDiretor'])
        ->name('escolas.vincular-diretor');

    // Categorias
    Route::resource('categorias', CategoriaController::class);

    // Produtos
    Route::resource('produtos', ProdutoController::class);

    // Pedidos
    Route::resource('pedidos', PedidoController::class);
    Route::post('/pedidos/{pedido}/aprovar', [PedidoController::class, 'aprovar'])->name('pedidos.aprovar');
    Route::post('/pedidos/{pedido}/recusar', [PedidoController::class, 'recusar'])->name('pedidos.recusar');

    // Solicitações de Alteração Escolar
    Route::prefix('solicitacoes')->name('solicitacoes.')->group(function () {
        Route::get('/', [SolicitacaoAlteracaoController::class, 'index'])->name('index');
        Route::get('/criar', [SolicitacaoAlteracaoController::class, 'create'])->name('create');
        Route::post('/', [SolicitacaoAlteracaoController::class, 'store'])->name('store');
        Route::get('/{solicitacao}', [SolicitacaoAlteracaoController::class, 'show'])->name('show');
        Route::patch('/{solicitacao}/aprovar', [SolicitacaoAlteracaoController::class, 'aprovar'])->name('aprovar');
        Route::patch('/{solicitacao}/recusar', [SolicitacaoAlteracaoController::class, 'recusar'])->name('recusar');
    });
});
