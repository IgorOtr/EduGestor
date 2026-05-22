<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Escola extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'diretor_id',
        'nome',
        'telefone',
        'endereco',
        'qnt_masc',
        'qnt_fem',
        'qnt_total',
        'faixa_etaria',
        'professores',
        'funcionarios',
    ];

    protected function casts(): array
    {
        return [
            'qnt_masc'      => 'integer',
            'qnt_fem'       => 'integer',
            'qnt_total'     => 'integer',
            'professores'   => 'integer',
            'funcionarios'  => 'integer',
        ];
    }

    public function diretor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diretor_id');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function solicitacoesAlteracao(): HasMany
    {
        return $this->hasMany(SolicitacaoAlteracao::class);
    }
}
