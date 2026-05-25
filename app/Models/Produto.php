<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'descricao',
        'categoria_id',
        'imagem',
        'qnt_min',
        'qnt_max',
        'unt_cust',
    ];

    protected function casts(): array
    {
        return [
            'qnt_min'  => 'integer',
            'qnt_max'  => 'integer',
            'unt_cust' => 'decimal:2',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function itensPedido(): HasMany
    {
        return $this->hasMany(ItemPedido::class);
    }
}
