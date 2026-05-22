<?php

namespace App\Models;

use App\Enums\ItemPedidoStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemPedido extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'item_pedidos';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'pedido_id',
        'produto_id',
        'qnt_solicit',
        'qnt_aprov',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'qnt_solicit' => 'integer',
            'qnt_aprov'   => 'integer',
            'status'      => ItemPedidoStatusEnum::class,
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
