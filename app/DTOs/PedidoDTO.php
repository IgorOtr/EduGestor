<?php

namespace App\DTOs;

class PedidoDTO
{
    public function __construct(
        public readonly string $escola_id,
        public readonly string $user_id,
        /** @var array<array{produto_id: string, qnt_solicit: int}> */
        public readonly array  $itens,
    ) {}

    public static function fromArray(array $data, string $userId): self
    {
        return new self(
            escola_id: $data['escola_id'],
            user_id:   $userId,
            itens:     $data['itens'],
        );
    }
}
