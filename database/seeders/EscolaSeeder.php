<?php

namespace Database\Seeders;

use App\Models\Escola;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;

class EscolaSeeder extends Seeder
{
    public function run(): void
    {
        $diretores = User::where('role', RoleEnum::Diretor)->get();

        $escolas = [
            [
                'nome'         => 'EMEF Prof. João Mendes',
                'telefone'     => '(11) 3333-1111',
                'endereco'     => 'Rua das Flores, 100, Centro',
                'qnt_masc'     => 120,
                'qnt_fem'      => 110,
                'qnt_total'    => 230,
                'faixa_etaria' => '6 a 14 anos',
                'professores'  => 15,
                'funcionarios' => 10,
            ],
            [
                'nome'         => 'EMEF Maria Auxiliadora',
                'telefone'     => '(11) 3333-2222',
                'endereco'     => 'Av. Brasil, 500, Jardim Nova Era',
                'qnt_masc'     => 90,
                'qnt_fem'      => 95,
                'qnt_total'    => 185,
                'faixa_etaria' => '6 a 12 anos',
                'professores'  => 12,
                'funcionarios' => 8,
            ],
            [
                'nome'         => 'EMEF Santos Dumont',
                'telefone'     => '(11) 3333-3333',
                'endereco'     => 'Rua da Independência, 250, Vila Nova',
                'qnt_masc'     => 150,
                'qnt_fem'      => 145,
                'qnt_total'    => 295,
                'faixa_etaria' => '6 a 15 anos',
                'professores'  => 18,
                'funcionarios' => 12,
            ],
        ];

        foreach ($escolas as $index => $dadosEscola) {
            $escola = Escola::create($dadosEscola);
            if ($diretores->has($index)) {
                $escola->update(['diretor_id' => $diretores[$index]->id]);
            }
        }
    }
}
