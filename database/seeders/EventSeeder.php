<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Quote;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Get quotes that are 'pagada' status
        $quotes = Quote::where('status', 'pagada')->get();
        

        foreach ($quotes as $quote) {
            $total_price = $quote->estimated_price;
            $advance = $total_price * 0.30;
            $remaining = $total_price - $advance;
            
            $estimated_start = new Carbon($quote->start_time);
            $estimated_end = new Carbon($quote->end_time);
            $duration = $estimated_start->diffInHours($estimated_end);
            
            Event::create([
                'quote_id' => $quote->id,
                'user_id' => $quote->user_id,
                'date' => $faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
                'status' => 'pendiente',
                'estimated_start_time' => $quote->start_time,
                'estimated_end_time' => $quote->end_time,
                'start_time' => null,
                'end_time' => null,
                'duration' => $duration,
                'chair_count' => $faker->numberBetween(50, 200),
                'table_count' => $faker->numberBetween(5, 20),
                'table_cloth_count' => $faker->numberBetween(5, 20),
                'total_price' => $total_price,
                'advance_payment' => $advance,
                'remaining_payment' => $remaining,
                'extra_hours' => null,
                'extra_hour_price' => $faker->randomFloat(2, 500, 1000),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}