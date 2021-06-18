<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;
use Illuminate\Support\Carbon;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produto::insert([
            [
                'nome'  => 'Sabao em Po',
                'descricao'  => 'limpeza',
                'valor' => 2,
                'image' => 'https://placeimg.com/640/480/arch',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Sabao Liquido',
                'descricao'  => 'limpeza',
                'valor' => 2,
                'image' => 'https://placeimg.com/640/480/arch',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Arroz',
                'descricao'  => 'limpeza',
                'valor' => 1,
                'image' => 'https://placeimg.com/640/480/arch',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Mouse',
                'descricao'  => 'limpeza',
                'valor' => 3,
                'image' => 'https://placeimg.com/640/480/arch',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
    
}
