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
            ['nome' => 'Sabão em Pó',         'categoria' => 'Material de Limpeza', 'qnt_min' => 2,  'qnt_max' => 50],
            ['nome' => 'Detergente 500ml',    'categoria' => 'Material de Limpeza', 'qnt_min' => 5,  'qnt_max' => 100],
            ['nome' => 'Vassoura',            'categoria' => 'Material de Limpeza', 'qnt_min' => 1,  'qnt_max' => 20],
            ['nome' => 'Caderno 100 folhas',  'categoria' => 'Material Escolar',    'qnt_min' => 10, 'qnt_max' => 500],
            ['nome' => 'Lápis HB',            'categoria' => 'Material Escolar',    'qnt_min' => 20, 'qnt_max' => 1000],
            ['nome' => 'Borracha',            'categoria' => 'Material Escolar',    'qnt_min' => 20, 'qnt_max' => 500],
            ['nome' => 'Caneta Azul',         'categoria' => 'Papelaria',           'qnt_min' => 10, 'qnt_max' => 500],
            ['nome' => 'Papel A4 (resma)',    'categoria' => 'Papelaria',           'qnt_min' => 5,  'qnt_max' => 100],
            ['nome' => 'Tesoura Escolar',     'categoria' => 'Material Escolar',    'qnt_min' => 5,  'qnt_max' => 100],
            ['nome' => 'Giz de Cera',         'categoria' => 'Material Escolar',    'qnt_min' => 10, 'qnt_max' => 300],
            ['nome' => 'Sabonete Líquido',    'categoria' => 'Higiene',             'qnt_min' => 5,  'qnt_max' => 100],
            ['nome' => 'Papel Toalha',        'categoria' => 'Higiene',             'qnt_min' => 5,  'qnt_max' => 200],
            ['nome' => 'Mouse USB',           'categoria' => 'Informática',         'qnt_min' => 1,  'qnt_max' => 30],
            ['nome' => 'Teclado USB',         'categoria' => 'Informática',         'qnt_min' => 1,  'qnt_max' => 30],
            ['nome' => 'Cadeira Estudante',   'categoria' => 'Mobiliário',          'qnt_min' => 5,  'qnt_max' => 100],
            ['nome' => 'Mesa Escolar',        'categoria' => 'Mobiliário',          'qnt_min' => 5,  'qnt_max' => 50],
            ['nome' => 'Bola de Futebol',     'categoria' => 'Esportes',            'qnt_min' => 1,  'qnt_max' => 10],
            ['nome' => 'Corda de Pular',      'categoria' => 'Esportes',            'qnt_min' => 2,  'qnt_max' => 30],
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
                ]);
            }
        }
    }
}
