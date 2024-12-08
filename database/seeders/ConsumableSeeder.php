<?php

namespace Database\Seeders;

use App\Models\Consumable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsumableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            [
                'name' => 'Papel de baño',
                'category_id' => 1,
                'unit' => 'pzas',
                'description' => 'Papel de baño suave y resistente',
            ],
            [
                'name' => 'Jabon de manos',
                'category_id' => 1,
                'unit' => 'pzas',
                'description' => 'Jabon liquido para manos',
            ],
            [
                'name' => 'Jabon de trastes',
                'category_id' => 3,
                'unit' => 'pzas',
                'description' => 'Jabon liquido para trastes',
            ],
            [
                'name' => 'Abono para plantas',
                'category_id' => 2,
                'unit' => 'gr',
                'description' => 'Abono para plantas de interior',
            ],
            [
                'name' => 'liquido para trapear',
                'category_id' => 1,
                'unit' => 'pzas',
                'description' => 'Liquido para trapear con aroma a limon',
            ],
            [
                'name' => 'Cloro',
                'category_id' => 5,
                'unit' => 'ml',
                'description' => 'Cloro para desinfectar',
            ]
        ];
        foreach ($products as $product) {
            Consumable::create([
                'name' => $product['name'],
                'stock' => 15,
                'minimum_stock' => 5,
                'maximum_stock' => 20,
                'unit' => $product['unit'],
                'category_id' => $product['category_id'],
                'description' => $product['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
