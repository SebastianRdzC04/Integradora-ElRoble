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
        $persona = new Person();
        $persona->first_name = 'Sebastián';
        $persona->last_name = 'Rodríguez';
        $persona->birthdate = '2001-05-04';
        $persona->gender = 'Masculino';
        $persona->phone = '8714980534';
        $persona->save();

        $persona = new Person();
        $persona->first_name = 'Jesús';
        $persona->last_name = 'Villareal';
        $persona->birthdate = '2001-05-04';
        $persona->gender = 'Masculino';
        $persona->phone = '8714980532';
        $persona->save();

        $persona = new Person();
        $persona->first_name = 'Axel';
        $persona->last_name = 'Espinoza';
        $persona->birthdate = '2004-12-16';
        $persona->gender = 'Masculino';
        $persona->phone = '8714017089';
        $persona->save();
        //
        $faker = Faker::create('es_MX');
        for ($i = 4; $i <= 14; $i++) {
            $person = new Person();
            $person->first_name = $faker->firstName;
            $person->last_name = $faker->lastName;
            $person->birthdate = $faker->date;
            $person->gender = $faker->randomElement(['Masculino', 'Femenino', 'Otro']);
            $person->phone = '9814980534';
            $person->age = $faker->numberBetween(18, 60);
            $person->save();
        }
        
    }
}
