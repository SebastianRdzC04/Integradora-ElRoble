<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Equipamiento
            [
                'category_id' => 1,
                'services' => [
                    [
                        'name' => 'Sillas y mesas',
                        'description' => 'Set de 10 mesas con 100 sillas',
                        'price' => 1500.00,
                        'people_quantity' => 100,
                        'coast' => 300.00
                    ],
                    [
                        'name' => 'Sistema de sonido',
                        'description' => 'Sistema de audio profesional con 2 bocinas y mezcladora',
                        'price' => 2000.00,
                        'coast' => 400.00
                    ],
                ]
            ],
            // Decoración
            [
                'category_id' => 2,
                'services' => [
                    [
                        'name' => 'Decoración básica',
                        'description' => 'Decoración con globos y telas',
                        'price' => 1200.00,
                        'people_quantity' => 0,
                        'coast' => 300.00
                    ],
                    [
                        'name' => 'Decoración premium',
                        'description' => 'Decoración completa con flores naturales y telas importadas',
                        'price' => 3500.00,
                        'people_quantity' => 0,
                        'coast' => 1000.00
                    ],
                ]
            ],
            // Comida
            [
                'category_id' => 3,
                'services' => [
                    [
                        'name' => 'Buffet básico',
                        'description' => 'Menú básico para 100 personas',
                        'price' => 5000.00,
                        'people_quantity' => 100,
                        'coast' => 2500.00
                    ],
                    [
                        'name' => 'Buffet premium',
                        'description' => 'Menú premium con 3 tiempos para 100 personas',
                        'price' => 8000.00,
                        'people_quantity' => 100,
                        'coast' => 4000.00
                    ],
                ]
            ],
            // Servicio
            [
                'category_id' => 4,
                'services' => [
                    [
                        'name' => 'Meseros',
                        'description' => 'Servicio de 5 meseros por 6 horas',
                        'price' => 2500.00,
                        'people_quantity' => 50,
                        'coast' => 1500.00
                    ],
                    [
                        'name' => 'Valet parking',
                        'description' => 'Servicio de valet parking para 50 autos',
                        'price' => 1800.00,
                        'people_quantity' => 50,
                        'coast' => 900.00
                    ],
                ]
            ],
            // Música
            [
                'category_id' => 5,
                'services' => [
                    [
                        'name' => 'DJ básico',
                        'description' => 'Servicio de DJ por 6 horas con equipo básico',
                        'price' => 3500.00,
                        'people_quantity' => 80,
                        'coast' => 1500.00
                    ],
                    [
                        'name' => 'Grupo versátil',
                        'description' => 'Grupo musical versátil por 4 horas',
                        'price' => 8000.00,
                        'people_quantity' => 100,
                        'coast' => 4000.00
                    ],
                ]
            ],
        ];

        foreach ($services as $categoryServices) {
            foreach ($categoryServices['services'] as $service) {
                Service::create([
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'service_category_id' => $categoryServices['category_id'],
                    'price' => $service['price'],
                    'people_quantity' => $service['people_quantity'] ?? null,
                    'coast' => $service['coast']
                ]);
            }
        }
    }
}