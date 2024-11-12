<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_MX');

        $eventTypes = [
            'Boda', 'XV años', 'Cumpleaños', 'Bautizo',
            'Primera Comunión', 'Graduación', 'Reunión Empresarial',
            'Baby Shower', 'Despedida de Soltero/a', 'Aniversario'
        ];

        // Helper function para generar horarios coherentes
        $getEventTimes = function() use ($faker) {
            $startHour = $faker->numberBetween(13, 19);
            $endHour = $startHour + $faker->numberBetween(5, 8);
            return [
                'start' => str_pad($startHour, 2, '0', STR_PAD_LEFT) . ':00:00',
                'end' => str_pad($endHour, 2, '0', STR_PAD_LEFT) . ':00:00'
            ];
        };

        // Quotes with packages
        for ($i = 1; $i <= 15; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(15000, 50000);
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(1, 6),
                'place_id' => null,
                'date' => $faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d'),
                'status' => $faker->randomElement(['pendiente', 'pagada', 'cancelada', 'pendiente cotizacion']),
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.30,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement($eventTypes),
                'guest_count' => $faker->numberBetween(50, 70),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-6 months', 'now')
            ]);
        }

        // Quotes without packages
        for ($i = 1; $i <= 20; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(10000, 40000);
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => null,
                'place_id' => rand(1, 3),
                'date' => $faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d'),
                'status' => $faker->randomElement(['pendiente', 'pagada', 'cancelada', 'pendiente cotizacion']),
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.30,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement($eventTypes),
                'guest_count' => $faker->numberBetween(50, 80),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-6 months', 'now')
            ]);
        }

        // Special events
        for ($i = 1; $i <= 5; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(45000, 70000);
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(5, 6),
                'place_id' => null,
                'date' => $faker->dateTimeBetween('2024-06-01', '2024-12-31')->format('Y-m-d'),
                'status' => $faker->randomElement(['pendiente', 'pagada']),
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.30,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement(['Boda', 'XV años']),
                'guest_count' => $faker->numberBetween(60, 80),
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => $faker->dateTimeBetween('-6 months', 'now')
            ]);
        }
    }
}