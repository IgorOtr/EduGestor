<?php

namespace App\Enums;

enum PedidoStatusEnum: string
{
    case Pendente            = 'pendente';
    case Aprovado            = 'aprovado';
    case ParcialmenteAprovado = 'parcialmente_aprovado';
    case Recusado            = 'recusado';

    public function label(): string
    {
        return match($this) {
            self::Pendente             => 'Pendente',
            self::Aprovado             => 'Aprovado',
            self::ParcialmenteAprovado => 'Parcialmente Aprovado',
            self::Recusado             => 'Recusado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pendente             => 'yellow',
            self::Aprovado             => 'green',
            self::ParcialmenteAprovado => 'blue',
            self::Recusado             => 'red',
        };
    }
}
