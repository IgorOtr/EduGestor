<?php

namespace App\Models;

use App\Enums\SolicitacaoStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitacaoAlteracao extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'solicitacao_alteracoes';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'escola_id',
        'user_id',
        'campos_alterados',
        'status',
        'obs_secretario',
        'avaliado_em',
        'avaliado_por',
    ];

    protected function casts(): array
    {
        return [
            'campos_alterados' => 'array',
            'status'           => SolicitacaoStatusEnum::class,
            'avaliado_em'      => 'datetime',
        ];
    }

    public function escola(): BelongsTo
    {
        return $this->belongsTo(Escola::class);
    }

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function avaliador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'avaliado_por');
    }
}
