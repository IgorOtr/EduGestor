<?php

namespace App\Enums;

enum SolicitacaoStatusEnum: string
{
    case Pendente = 'pendente';
    case Aprovado = 'aprovado';
    case Recusado = 'recusado';

    public function label(): string
    {
        return match($this) {
            self::Pendente => 'Pendente',
            self::Aprovado => 'Aprovado',
            self::Recusado => 'Recusado',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pendente => 'yellow',
            self::Aprovado => 'green',
            self::Recusado => 'red',
        };
    }
}
