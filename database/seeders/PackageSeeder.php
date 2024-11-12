<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            // Quinta packages (place_id: 1)
            [
                'place_id' => 1,
                'name' => 'Paquete Básico Quinta',
                'description' => 'Incluye: Uso de alberca, área de jardín, mobiliario básico (100 sillas, 10 mesas), equipo de sonido básico y decoración básica',
                'max_people' => 50,
                'price' => 15000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ],
            [
                'place_id' => 1,
                'name' => 'Paquete Premium Quinta',
                'description' => 'Incluye: Uso de alberca, área de jardín, mobiliario premium (150 sillas, 15 mesas), sistema de sonido profesional, decoración premium, y servicio de 6 meseros',
                'max_people' => 50,
                'price' => 25000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ],
            
            // Salon packages (place_id: 2)
            [
                'place_id' => 2,
                'name' => 'Paquete Básico Salón',
                'description' => 'Incluye: Uso del salón climatizado, mobiliario básico (100 sillas, 10 mesas), equipo de sonido básico y decoración básica',
                'max_people' => 100,
                'price' => 18000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ],
            [
                'place_id' => 2,
                'name' => 'Paquete Premium Salón',
                'description' => 'Incluye: Uso del salón climatizado, mobiliario premium (100 sillas, 20 mesas), sistema de sonido profesional, decoración premium, y servicio de 8 meseros',
                'max_people' => 100,
                'price' => 30000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ],

            // Quinta y Salon packages (place_id: 3)
            [
                'place_id' => 3,
                'name' => 'Paquete Completo Básico',
                'description' => 'Incluye: Uso de quinta y salón, mobiliario básico (100 sillas, 20 mesas), sistema de sonido básico, decoración básica y servicio de 6 meseros',
                'max_people' => 100,
                'price' => 35000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ],
            [
                'place_id' => 3,
                'name' => 'Paquete Completo Premium',
                'description' => 'Incluye: Uso de quinta y salón, mobiliario premium (100 sillas, 30 mesas), sistema de sonido profesional, decoración premium, servicio de 10 meseros y valet parking',
                'max_people' => 100,
                'price' => 50000,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'status' => 'activo'
            ]
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
