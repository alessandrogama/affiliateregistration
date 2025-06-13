<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Affiliate;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $afiliados = [
            [
                'username' => 'sistema',
                'nickname' => 'Admin',
                'email' => 'sistema@dominio.com',
                'base_percentage' => 0,
            ],
            [
                'username' => 'joao123',
                'nickname' => 'João',
                'email' => 'joao@example.com',
                'base_percentage' => 10,
            ],
            [
                'username' => 'maria456',
                'nickname' => 'Maria',
                'email' => 'maria@example.com',
                'base_percentage' => 12,
            ],
            [
                'username' => 'lucas789',
                'nickname' => 'Lucas',
                'email' => 'lucas@example.com',
                'base_percentage' => 15,
            ],
        ];

        foreach ($afiliados as $afiliado) {
            Affiliate::create($afiliado);
        }

    }
}
