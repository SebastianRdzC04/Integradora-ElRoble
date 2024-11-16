<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlacesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $places = [
            [
                'name' => 'Quinta',
                'description' => 'Quinta con alberca'
            ],
            [
                'name' => 'Salon',
                'description' => 'Salon elegante '
            ],
            [
                'name' => 'Quinta y salon',
                'description' => 'Conjunto de Quinta y Salon para fiestas grandes'
            ],
            ];
        foreach ($places as $place) {
            Place::create([
                'name' => $place['name'],
                'description' => $place['description']
            ]);
        }
    }
}
