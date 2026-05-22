<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Root      = 'root';
    case Secretario = 'secretario';
    case Diretor   = 'diretor';

    public function label(): string
    {
        return match($this) {
            RoleEnum::Root       => 'Root',
            RoleEnum::Secretario => 'Secretário',
            RoleEnum::Diretor    => 'Diretor',
        };
    }

    public function color(): string
    {
        return match($this) {
            RoleEnum::Root       => 'red',
            RoleEnum::Secretario => 'blue',
            RoleEnum::Diretor    => 'green',
        };
    }
}
