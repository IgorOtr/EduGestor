<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('color')->default('#3b82f6');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('produtos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('categoria_id');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('imagem')->nullable();
            $table->unsignedInteger('qnt_min')->default(1);
            $table->unsignedInteger('qnt_max')->default(100);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('categoria_id')->references('id')->on('categorias');
        });

        Schema::create('escolas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('diretor_id')->nullable();
            $table->string('nome');
            $table->string('telefone')->nullable();
            $table->string('endereco')->nullable();
            $table->unsignedInteger('qnt_masc')->default(0);
            $table->unsignedInteger('qnt_fem')->default(0);
            $table->unsignedInteger('qnt_total')->default(0);
            $table->string('faixa_etaria')->nullable();
            $table->unsignedInteger('professores')->default(0);
            $table->unsignedInteger('funcionarios')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('diretor_id')->references('id')->on('users');
        });

        Schema::create('pedidos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('escola_id');
            $table->uuid('user_id');
            $table->string('status')->default('pendente');
            $table->text('obs_secretario')->nullable();
            $table->timestamp('aprovado_em')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('escola_id')->references('id')->on('escolas');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('item_pedidos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pedido_id');
            $table->uuid('produto_id');
            $table->unsignedInteger('qnt_solicit');
            $table->unsignedInteger('qnt_aprov')->nullable();
            $table->string('status')->default('pendente');
            $table->timestamps();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });

        Schema::create('solicitacao_alteracoes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('escola_id');
            $table->uuid('user_id');
            $table->json('campos_alterados');
            $table->string('status')->default('pendente');
            $table->text('obs_secretario')->nullable();
            $table->timestamp('avaliado_em')->nullable();
            $table->uuid('avaliado_por')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('escola_id')->references('id')->on('escolas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('avaliado_por')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitacao_alteracoes');
        Schema::dropIfExists('item_pedidos');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('escolas');
        Schema::dropIfExists('produtos');
        Schema::dropIfExists('categorias');
    }
};
