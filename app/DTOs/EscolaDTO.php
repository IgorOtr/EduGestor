<?php

namespace App\DTOs;

class EscolaDTO
{
    public function __construct(
        public readonly string  $nome,
        public readonly ?string $diretor_id = null,
        public readonly ?string $telefone = null,
        public readonly ?string $endereco = null,
        public readonly int     $qnt_masc = 0,
        public readonly int     $qnt_fem = 0,
        public readonly int     $qnt_total = 0,
        public readonly ?string $faixa_etaria = null,
        public readonly int     $professores = 0,
        public readonly int     $funcionarios = 0,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            nome:          $data['nome'],
            diretor_id:    $data['diretor_id'] ?? null,
            telefone:      $data['telefone'] ?? null,
            endereco:      $data['endereco'] ?? null,
            qnt_masc:      (int) ($data['qnt_masc'] ?? 0),
            qnt_fem:       (int) ($data['qnt_fem'] ?? 0),
            qnt_total:     (int) ($data['qnt_total'] ?? 0),
            faixa_etaria:  $data['faixa_etaria'] ?? null,
            professores:   (int) ($data['professores'] ?? 0),
            funcionarios:  (int) ($data['funcionarios'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'nome'         => $this->nome,
            'diretor_id'   => $this->diretor_id,
            'telefone'     => $this->telefone,
            'endereco'     => $this->endereco,
            'qnt_masc'     => $this->qnt_masc,
            'qnt_fem'      => $this->qnt_fem,
            'qnt_total'    => $this->qnt_total,
            'faixa_etaria' => $this->faixa_etaria,
            'professores'  => $this->professores,
            'funcionarios' => $this->funcionarios,
        ], fn($v) => !is_null($v));
    }
}
