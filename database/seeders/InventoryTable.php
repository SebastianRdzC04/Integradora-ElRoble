<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($j = 1; $j <= 70; $j++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 1;
            $inventory->number = $j;
            $inventory->description = 'Silla negra normal';
            $inventory->price = 90.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 2;
            $inventory->number = $i;
            $inventory->description = 'Sillas chicas para niños';
            $inventory->price = 70.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 3;
            $inventory->number = $i;
            $inventory->description = 'Mesa cuadrada para 8 personas';
            $inventory->price = 500.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 4;
            $inventory->number = $i;
            $inventory->description = 'Mesa rectangular para 10 personas';
            $inventory->price = 600.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 5;
            $inventory->number = $i;
            $inventory->description = 'Mesa redonda para 10 personas';
            $inventory->price = 700.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 100; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 6;
            $inventory->number = $i;
            $inventory->description = 'Vasos de Vidro de 8 onzas';
            $inventory->price = 20.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 100; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number_type_id = 7;
            $inventory->number = $i;
            $inventory->description = 'Platos de loza de 8 pulgadas';
            $inventory->price = 30.00;
            $inventory->save();
        }
    }
}
