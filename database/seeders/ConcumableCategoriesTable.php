<?php

namespace Database\Seeders;

use App\Models\ConsumableCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConcumableCategoriesTable extends Seeder
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
            'Limpieza',
            'Plantas',
            'Cocina',
            'Hornos',
            'Alberca'
        ];
        foreach ($categories as $category) {
            $consumableCategory = new ConsumableCategory();
            $consumableCategory->name = $category;
            $consumableCategory->save();
        }
    }
}
