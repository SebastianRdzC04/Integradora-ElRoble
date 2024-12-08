<?php

namespace Database\Seeders;

use App\Models\Quote;
use DateTime;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Collection;

class QuoteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('es_MX');
        $usedDates = new Collection();
        $paidDates = new Collection();

        $eventTypes = [
            'Boda', 'XV años', 'Cumpleaños', 'Bautizo',
            'Primera Comunión', 'Graduación', 'Reunión Empresarial',
            'Baby Shower', 'Despedida de Soltero/a', 'Aniversario'
        ];

        $getEventTimes = function() use ($faker) {
            $startHour = $faker->numberBetween(13, 19);
            $duration = $faker->numberBetween(5, 8);
            $start = new DateTime($startHour . ':00');
            $end = clone $start;
            $end->modify("+{$duration} hours");
            if ($end->format('H') > 23) {
                $end->setTime(23, 59);
            }
            return [
                'start' => $start->format('H:i:s'),
                'end' => $end->format('H:i:s')
            ];
        };

        $getUniqueDate = function($startDate, $endDate) use ($faker, $usedDates, &$paidDates) {
            do {
                $date = $faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d');
                $dateCount = $usedDates->where('date', $date)->count();
            } while ($dateCount >= 3);
            
            $usedDates->push(['date' => $date]);
            return $date;
        };

        // 100 cotizaciones pagadas/canceladas (Enero-Noviembre 2024)
        for ($i = 1; $i <= 390; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(45000, 80000);
            $date = $getUniqueDate('2022-01-01', '2024-11-30');
            
            $status = 'cancelada';
            if ($faker->boolean(30) && !$paidDates->contains($date)) {
                $status = 'pagada';
                $paidDates->push($date);
            }
            
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(1, 6),
                'place_id' => null,
                'date' => $date,
                'status' => $status,
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.30,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement($eventTypes),
                'guest_count' => $faker->numberBetween(60, 150),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 10 cotizaciones pendientes de cotizar (Diciembre 2024-Febrero 2025)
        for ($i = 1; $i <= 10; $i++) {
            $times = $getEventTimes();
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(1, 6),
                'place_id' => null,
                'date' => $getUniqueDate('2024-12-01', '2025-02-28'),
                'status' => 'pendiente cotizacion',
                'estimated_price' => 0,
                'espected_advance' => 0,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement($eventTypes),
                'guest_count' => $faker->numberBetween(50, 70),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 15 cotizaciones pendientes (Diciembre 2024-Febrero 2025)
        for ($i = 1; $i <= 15; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(45000, 70000);
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(1, 6),
                'place_id' => null,
                'date' => $getUniqueDate('2024-12-01', '2025-02-28'),
                'status' => 'pendiente',
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.30,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement($eventTypes),
                'guest_count' => $faker->numberBetween(60, 80),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 10 cotizaciones pagadas (Diciembre 2024-Febrero 2025)
        for ($i = 1; $i <= 10; $i++) {
            $times = $getEventTimes();
            $estimated_price = $faker->numberBetween(50000, 80000);
            
            do {
                $date = $faker->dateTimeBetween('2024-12-01', '2025-02-28')->format('Y-m-d');
            } while ($paidDates->contains($date) || $usedDates->where('date', $date)->count() >= 3);
            
            $paidDates->push($date);
            $usedDates->push(['date' => $date]);
            
            Quote::create([
                'user_id' => rand(1, 10),
                'package_id' => rand(1, 6),
                'place_id' => null,
                'date' => $date,
                'status' => 'pagada',
                'estimated_price' => $estimated_price,
                'espected_advance' => $estimated_price * 0.50,
                'start_time' => $times['start'],
                'end_time' => $times['end'],
                'type_event' => $faker->randomElement(['Boda', 'XV años', 'Graduación']),
                'guest_count' => $faker->numberBetween(100, 150),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Attach services
        Quote::all()->each(function($quote) {
            $quote->services()->attach([1, 2, 3,4,5,6,7,8,9]);
        });
    }
}