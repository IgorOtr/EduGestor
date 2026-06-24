<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            ['nome' => 'Sabão em Pó',         'categoria' => 'Material de Limpeza', 'qnt_min' => 2,  'qnt_max' => 50,   'unt_cust' => 8.90],
            ['nome' => 'Detergente 500ml',    'categoria' => 'Material de Limpeza', 'qnt_min' => 5,  'qnt_max' => 100,  'unt_cust' => 3.50],
            ['nome' => 'Vassoura',            'categoria' => 'Material de Limpeza', 'qnt_min' => 1,  'qnt_max' => 20,   'unt_cust' => 18.00],
            ['nome' => 'Caderno 100 folhas',  'categoria' => 'Material Escolar',    'qnt_min' => 10, 'qnt_max' => 500,  'unt_cust' => 7.90],
            ['nome' => 'Lápis HB',            'categoria' => 'Material Escolar',    'qnt_min' => 20, 'qnt_max' => 1000, 'unt_cust' => 0.90],
            ['nome' => 'Borracha',            'categoria' => 'Material Escolar',    'qnt_min' => 20, 'qnt_max' => 500,  'unt_cust' => 1.20],
            ['nome' => 'Caneta Azul',         'categoria' => 'Papelaria',           'qnt_min' => 10, 'qnt_max' => 500,  'unt_cust' => 1.50],
            ['nome' => 'Papel A4 (resma)',    'categoria' => 'Papelaria',           'qnt_min' => 5,  'qnt_max' => 100,  'unt_cust' => 29.90],
            ['nome' => 'Tesoura Escolar',     'categoria' => 'Material Escolar',    'qnt_min' => 5,  'qnt_max' => 100,  'unt_cust' => 6.50],
            ['nome' => 'Giz de Cera',         'categoria' => 'Material Escolar',    'qnt_min' => 10, 'qnt_max' => 300,  'unt_cust' => 5.90],
            ['nome' => 'Sabonete Líquido',    'categoria' => 'Higiene',             'qnt_min' => 5,  'qnt_max' => 100,  'unt_cust' => 9.80],
            ['nome' => 'Papel Toalha',        'categoria' => 'Higiene',             'qnt_min' => 5,  'qnt_max' => 200,  'unt_cust' => 12.50],
            ['nome' => 'Mouse USB',           'categoria' => 'Informática',         'qnt_min' => 1,  'qnt_max' => 30,   'unt_cust' => 45.00],
            ['nome' => 'Teclado USB',         'categoria' => 'Informática',         'qnt_min' => 1,  'qnt_max' => 30,   'unt_cust' => 89.90],
            ['nome' => 'Cadeira Estudante',   'categoria' => 'Mobiliário',          'qnt_min' => 5,  'qnt_max' => 100,  'unt_cust' => 185.00],
            ['nome' => 'Mesa Escolar',        'categoria' => 'Mobiliário',          'qnt_min' => 5,  'qnt_max' => 50,   'unt_cust' => 320.00],
            ['nome' => 'Bola de Futebol',     'categoria' => 'Esportes',            'qnt_min' => 1,  'qnt_max' => 10,   'unt_cust' => 65.00],
            ['nome' => 'Corda de Pular',      'categoria' => 'Esportes',            'qnt_min' => 2,  'qnt_max' => 30,   'unt_cust' => 14.90],
        ];

        foreach ($produtos as $p) {
            $categoria = Categoria::where('name', $p['categoria'])->first();
            if ($categoria) {
                Produto::create([
                    'nome'         => $p['nome'],
                    'descricao'    => 'Produto: ' . $p['nome'],
                    'categoria_id' => $categoria->id,
                    'qnt_min'      => $p['qnt_min'],
                    'qnt_max'      => $p['qnt_max'],
                    'unt_cust'     => $p['unt_cust'],
                ]);
            }
        }
    }
}
