<?php

namespace Database\Seeders;

use App\Models\Consumable;
use App\Models\ConsumableEventDefault;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsumableDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $consumables = Consumable::all();
        foreach ($consumables as $consumable) {
            ConsumableEventDefault::create([
                'consumable_id' => $consumable->id,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
