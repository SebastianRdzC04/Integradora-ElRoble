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
        //
        $categories = [
            'Equipamiento',
            'Decoracion',
            'Comida',
            'Servicio',
            'Musica'
        ];
        foreach ($categories as $category) {
            $serviceCategory = new ServiceCategory();
            $serviceCategory->name = $category;
            $serviceCategory->save();
        }
    }
}
