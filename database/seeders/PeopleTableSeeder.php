<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for ($i = 1; $i <= 10; $i++) {
            $person = new Person();
            $person->firstName = $faker->name;
            $person->lastName = $faker->lastName;
            $person->birthdate = $faker->date;
            $person->gender = $faker->randomElement(['Masculino', 'Femenino', 'Otro']);
            $person->phone = '9814980534';
            $person->age = $faker->numberBetween(18, 60);
            $person->save();
        }
        
    }
}
