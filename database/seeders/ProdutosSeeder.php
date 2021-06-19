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
                'image' => 'https://images-americanas.b2w.io/produtos/01/00/img/74189/4/74189452_1GG.jpg',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Sabao Liquido',
                'descricao'  => 'limpeza',
                'valor' => 2,
                'image' => 'https://images-americanas.b2w.io/produtos/01/00/img/1513868/7/1513868788_1GG.jpg',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Arroz',
                'descricao'  => 'cereais',
                'valor' => 1,
                'image' => 'https://images-americanas.b2w.io/produtos/01/00/img7/01/00/item/1633633/4/1633633481_1GG.jpg',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'nome'  => 'Mouse',
                'descricao'  => 'eletrônicos',
                'valor' => 3,
                'image' => 'https://images-americanas.b2w.io/produtos/01/00/img/1076480/7/1076480792_1GG.jpg',
                'ativo' => 's',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
    
}
