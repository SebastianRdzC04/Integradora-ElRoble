<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //ejecutar people seeder
        $this->call(PeopleTableSeeder::class);
        $this->call(ConcumableCategoriesTable::class);
        $this->call(ServiceCategoriesTable::class);
        $this->call(InventoryCategoriesTable::class);
        $this->call(PlacesTable::class);


        $faker = Faker::create('es_MX');
        
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->email = $faker->email;
            $user->password = Hash::make('password');
            $user->person_id = $i;
            $user->save();
        }
        




    }
}
