<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryCategoriesTable extends Seeder
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
            'Sillas',
            'Mesas',
            'Hieleras',
            'Utensilios'
        ];
        foreach ($categories as $category) {
            InventoryCategory::create([
                'name' => $category
            ]);
        }
    }
}
