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
        //$this->call(RolesSeeder::class);
        $this->call(SerialNumberSeeder::class);
        $this->call(InventoryTable::class);
        $this->call(ServiceSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(ConsumableSeeder::class);
        $this->call(ConsumableDefaultSeeder::class);

        $usuario = new User();
        $usuario->nickname = 'SebasRdz';
        $usuario->email = 'sebas@superadmin.com';
        $usuario->email_verified_at = now();
        $usuario->password = Hash::make('1234567890');
        $usuario->person_id = 1;
        $usuario->save();
        $usuario->roles()->attach(1);
        $usuario->roles()->attach(2);

        $usuario = new User();
        $usuario->nickname = 'JesusElpro';
        $usuario->email = 'jesus@admin.com';
        $usuario->email_verified_at = now();
        $usuario->password = Hash::make('1234567890');
        $usuario->person_id = 2;
        $usuario->save();
        $usuario->roles()->attach(2);

        $usuario = new User();
        $usuario->nickname = 'AxelYYa';
        $usuario->email = 'axelyya@worker.com';
        $usuario->email_verified_at = now();
        $usuario->password = Hash::make('1234567890');
        $usuario->person_id = 3;
        $usuario->save();
        $usuario->roles()->attach(2);






        for ($i = 4; $i <= 14; $i++) {
            $faker = Faker::create('es_MX');
            $user = new User();
            $user->email = $faker->email;
            $user->password = Hash::make('password');
            $user->person_id = $i;
            $user->save();
        }


        $this->call(QuoteSeeder::class);
        $this->call(EventSeeder::class);
        



        




    }
}
