<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['name' => 'Material de Limpeza',    'color' => '#10b981'],
            ['name' => 'Material Escolar',        'color' => '#3b82f6'],
            ['name' => 'Alimentação',             'color' => '#f59e0b'],
            ['name' => 'Informática',             'color' => '#8b5cf6'],
            ['name' => 'Mobiliário',              'color' => '#ef4444'],
            ['name' => 'Papelaria',               'color' => '#ec4899'],
            ['name' => 'Esportes',                'color' => '#06b6d4'],
            ['name' => 'Higiene',                 'color' => '#84cc16'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }
    }
}
