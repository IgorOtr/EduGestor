<?php

namespace App\Models;

use App\Enums\RoleEnum;
use App\Traits\HasAudit;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, SoftDeletes, HasAudit;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'telefone',
        'matricula',
        'endereco',
        'role',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => RoleEnum::class,
        ];
    }

    public function isRoot(): bool
    {
        return $this->role === RoleEnum::Root;
    }

    public function isSecretario(): bool
    {
        return $this->role === RoleEnum::Secretario;
    }

    public function isDiretor(): bool
    {
        return $this->role === RoleEnum::Diretor;
    }

    public function escola(): HasOne
    {
        return $this->hasOne(Escola::class, 'diretor_id');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'user_id');
    }

    public function solicitacoesAlteracao(): HasMany
    {
        return $this->hasMany(SolicitacaoAlteracao::class, 'user_id');
    }
}

