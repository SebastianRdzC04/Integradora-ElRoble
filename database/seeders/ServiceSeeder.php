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
                        'coast' => 300.00,
                        'image_file' => 'sillasymesas.jpeg'
                    ],
                    [
                        'name' => 'Sistema de sonido',
                        'description' => 'Sistema de audio profesional con 2 bocinas y mezcladora',
                        'price' => 2000.00,
                        'coast' => 400.00,
                        'image_file' => 'audioprofesional.jpg'
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
                        'coast' => 300.00,
                        'image_file' => 'decoracionglobosbasica.jpeg'
                    ],
                    [
                        'name' => 'Decoración premium',
                        'description' => 'Decoración completa con flores naturales y telas importadas',
                        'price' => 3500.00,
                        'people_quantity' => 0,
                        'coast' => 1000.00,
                        'image_file' => 'decoracionglobosytelas.jpg'
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
                        'coast' => 2500.00,
                        'image_file' => 'menupara100personas.jpeg'

                    ],
                    [
                        'name' => 'Buffet premium',
                        'description' => 'Menú premium con 3 tiempos para 100 personas',
                        'price' => 8000.00,
                        'people_quantity' => 100,
                        'coast' => 4000.00,
                        'image_file' => 'menupremium.jpg'

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
                        'coast' => 1500.00,
                        'image_file' => '5meseros.jpeg'

                    ],
                    [
                        'name' => 'Valet parking',
                        'description' => 'Servicio de valet parking para 50 autos',
                        'price' => 1800.00,
                        'people_quantity' => 50,
                        'coast' => 900.00,
                        'image_file' => 'valetparking.jpeg'

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
                        'coast' => 1500.00,
                        'image_file' => 'djprofesional.jpg'

                    ],
                    [
                        'name' => 'Grupo versátil',
                        'description' => 'Grupo musical versátil por 4 horas',
                        'price' => 8000.00,
                        'people_quantity' => 100,
                        'coast' => 4000.00,
                        'image_file' => 'grupomusical.jpeg'

                    ],
                ]
            ],
        ];

        foreach ($services as $categoryServices) {
            foreach ($categoryServices['services'] as $service) {
                $localImagePath = storage_path("app/temp_images/service_images/" . $service['image_file']);

                if (file_exists($localImagePath)) {
                    $pathInS3 = Storage::disk('s3')->putFile('services_images', $localImagePath, 'public');
                    $url = Storage::disk('s3')->url($pathInS3); 
                } else {
                    $url = null; 
                }

                Service::create([
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'service_category_id' => $categoryServices['category_id'],
                    'price' => $service['price'],
                    'people_quantity' => $service['people_quantity'] ?? null,
                    'coast' => $service['coast'],
                    'image_path' => $url,
                ]);
            }
        }
    }
}