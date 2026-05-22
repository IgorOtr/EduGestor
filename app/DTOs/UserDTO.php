<?php

namespace App\DTOs;

use App\Enums\RoleEnum;

class UserDTO
{
    public function __construct(
        public readonly string  $nome,
        public readonly string  $email,
        public readonly string  $password,
        public readonly RoleEnum $role,
        public readonly ?string $telefone = null,
        public readonly ?string $matricula = null,
        public readonly ?string $endereco = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nome:      $data['nome'],
            email:     $data['email'],
            password:  $data['password'],
            role:      RoleEnum::from($data['role']),
            telefone:  $data['telefone'] ?? null,
            matricula: $data['matricula'] ?? null,
            endereco:  $data['endereco'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'nome'      => $this->nome,
            'email'     => $this->email,
            'password'  => $this->password,
            'role'      => $this->role->value,
            'telefone'  => $this->telefone,
            'matricula' => $this->matricula,
            'endereco'  => $this->endereco,
        ];
    }
}
