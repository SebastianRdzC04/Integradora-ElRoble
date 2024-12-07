<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategoriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Equipamiento',
                'description' => 'Todo el equipo necesario para tu evento.'
            ],
            [
                'name' => 'Decoración',
                'description' => 'Elementos decorativos para ambientar tu evento.'
            ],
            [
                'name' => 'Comida',
                'description' => 'Servicios de catering, platillos y bebidas para tu evento.'
            ],
            [
                'name' => 'Servicio',
                'description' => 'Personal de servicio: meseros, limpieza y más.'
            ],
            [
                'name' => 'Música',
                'description' => 'Servicios de entretenimiento musical.'
            ]
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name' => $category['name'],
                'description' => $category['description']
            ]);
        }
    }
}