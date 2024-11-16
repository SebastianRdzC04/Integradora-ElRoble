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
        $this->call(PeopleTableSeeder::class);
        $this->call(ConcumableCategoriesTable::class);
        $this->call(ServiceCategoriesTable::class);
        $this->call(InventoryCategoriesTable::class);
        $this->call(PlacesTable::class);
        $this->call(RolesSeeder::class);
        $this->call(SerialNumberSeeder::class);
        $this->call(InventoryTable::class);
        $this->call(ServiceSeeder::class);
        $this->call(PackageSeeder::class);


        for ($i = 1; $i <= 10; $i++) {
            $faker = Faker::create('es_MX');
            $user = new User();
            $user->email = $faker->email;
            $user->password = Hash::make('password');
            $user->person_id = $i;
            $user->save();
        }


        $this->call(QuoteSeeder::class);



        




    }
}
