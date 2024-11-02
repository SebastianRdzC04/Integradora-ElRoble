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
            $inventory->serial_number = 'sn-'. $j;
            $inventory->name = 'Silla Normal';
            $inventory->description = 'Silla negra normal';
            $inventory->category_id = 1;
            $inventory->price = 90.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 50; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'sc-'. $i;
            $inventory->name = 'Sillas chicas';
            $inventory->description = 'Sillas chicas para niños';
            $inventory->category_id = 1;
            $inventory->price = 70.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'mc-'. $i;
            $inventory->name = 'Mesa Cuadrada';
            $inventory->description = 'Mesa cuadrada para 8 personas';
            $inventory->category_id = 2;
            $inventory->price = 500.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'mr-'. $i;
            $inventory->name = 'Mesa Rectangular';
            $inventory->description = 'Mesa rectangular para 10 personas';
            $inventory->category_id = 2;
            $inventory->price = 600.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 5; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'mrc-'. $i;
            $inventory->name = 'Mesa Redonda';
            $inventory->description = 'Mesa redonda para 10 personas';
            $inventory->category_id = 2;
            $inventory->price = 700.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 100; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'vc-'. $i;
            $inventory->name = 'Vasos de vidrio';
            $inventory->description = 'Vasos de Vidro de 8 onzas';
            $inventory->category_id = 4;
            $inventory->price = 20.00;
            $inventory->save();
        }
        for ($i = 1; $i <= 100; $i++) {
            $inventory = new Inventory();
            $inventory->serial_number = 'pl-'. $i;
            $inventory->name = 'Platos de loza';
            $inventory->description = 'Platos de loza de 8 pulgadas';
            $inventory->category_id = 4;
            $inventory->price = 30.00;
            $inventory->save();
        }
    }
}
