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
                'description' => 'Quinta con alberca',
                'max_guests' => 50,
                'price' => 2500,
            ],
            [
                'name' => 'Salón',
                'description' => 'Salón elegante ',
                'max_guests' => 60,
                'price' => 3000,
            ],
            [
                'name' => 'Quinta y Salón',
                'description' => 'Conjunto de Quinta y Salón para fiestas grandes',
                'max_guests' => 100,
                'price' => 5000,
            ],
            ];
        foreach ($places as $place) {
            Place::create([
                'name' => $place['name'],
                'description' => $place['description'],
                'max_guest' => $place['max_guests']
            ]);
        }
    }
}
