<?php

namespace App\Enums;

enum ItemPedidoStatusEnum: string
{
    case Pendente  = 'pendente';
    case Aprovado  = 'aprovado';
    case Recusado  = 'recusado';
    case Parcial   = 'parcial';

    public function label(): string
    {
        return match($this) {
            self::Pendente => 'Pendente',
            self::Aprovado => 'Aprovado',
            self::Recusado => 'Recusado',
            self::Parcial  => 'Parcial',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pendente => 'yellow',
            self::Aprovado => 'green',
            self::Recusado => 'red',
            self::Parcial  => 'blue',
        };
    }
}
