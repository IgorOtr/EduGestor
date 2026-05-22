<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Root
        User::create([
            'nome'      => 'Administrador Root',
            'email'     => 'root@edugestor.com',
            'password'  => Hash::make('password'),
            'role'      => RoleEnum::Root,
            'matricula' => 'ROOT001',
        ]);

        // Secretário
        User::create([
            'nome'      => 'Secretário Municipal',
            'email'     => 'secretario@edugestor.com',
            'password'  => Hash::make('password'),
            'role'      => RoleEnum::Secretario,
            'telefone'  => '(11) 99999-0001',
            'matricula' => 'SEC001',
        ]);

        // Diretores
        $diretores = [
            ['nome' => 'Diretora Ana Lima', 'email' => 'ana.lima@edugestor.com', 'matricula' => 'DIR001'],
            ['nome' => 'Diretor Carlos Souza', 'email' => 'carlos.souza@edugestor.com', 'matricula' => 'DIR002'],
            ['nome' => 'Diretora Maria Costa', 'email' => 'maria.costa@edugestor.com', 'matricula' => 'DIR003'],
        ];

        foreach ($diretores as $d) {
            User::create([
                'nome'      => $d['nome'],
                'email'     => $d['email'],
                'password'  => Hash::make('password'),
                'role'      => RoleEnum::Diretor,
                'matricula' => $d['matricula'],
                'telefone'  => '(11) 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
            ]);
        }
    }
}
