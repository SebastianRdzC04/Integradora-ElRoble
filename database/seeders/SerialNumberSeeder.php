<?php

namespace Database\Seeders;

use App\Models\SerialNumberType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SerialNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $base = [
            [
                'code' => 'SN',
                'name' => 'Sillas normales',
                'category' => 1,
            ],
            [
                'code' => 'SC',
                'name' => 'Sillas chicas',
                'category' => 1,
            ],
            [
                'code' => 'MC',
                'name' => 'Mesas cuadradas',
                'category' => 2,
            ],
            [
                'code' => 'MR',
                'name' => 'Mesas rectangulares',
                'category' => 2,
            ],
            [
                'code' => 'MRC',
                'name' => 'Mesas redondas',
                'category' => 2,
            ],
            [
                'code' => 'HCH',
                'name' => 'Hielera chica',
                'category' => 3,
            ],
            [
                'code' => 'HGR',
                'name' => 'Hielera grande',
                'category' => 3,
            ],
            [
                'code' => 'VC',
                'name' => 'Vasos de vidrio',
                'category' => 4,
            ],
            [
                'code' => 'PL',
                'name' => 'Platos de loza',
                'category' => 4,
            ],
        ];
        foreach ($base as $data) {
            $serialNumber = new SerialNumberType();
            $serialNumber->code = $data['code'];
            $serialNumber->name = $data['name'];
            $serialNumber->category_id = $data['category'];
            $serialNumber->save();
        }
    }
}
