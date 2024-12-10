<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Service;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ServicesPackages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $packages = Package::all();
        $services = Service::all();

        foreach ($packages as $package) {
            $uniqueServices = $services->pluck('id')->shuffle()->take(rand(1, 5));

            foreach ($uniqueServices as $serviceId) {
                $package->services()->attach($serviceId, [
                    'quantity' => rand(1, 10),
                    'price' => rand(600, 900),
                    'description' => $faker->sentence,
                    'coast' => rand(300, 400),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
