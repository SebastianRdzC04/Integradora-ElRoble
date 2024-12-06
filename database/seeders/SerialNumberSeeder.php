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
                'name' => 'Sillas Normales',
                'category' => 1,
            ],
            [
                'code' => 'SC',
                'name' => 'Sillas Chicas',
                'category' => 1,
            ],
            [
                'code' => 'MC',
                'name' => 'Mesas Cuadradas',
                'category' => 2,
            ],
            [
                'code' => 'MR',
                'name' => 'Mesas Rectangulares',
                'category' => 2,
            ],
            [
                'code' => 'MRC',
                'name' => 'Mesas Redondas',
                'category' => 2,
            ],
            [
                'code' => 'HCH',
                'name' => 'Hielera Chica',
                'category' => 3,
            ],
            [
                'code' => 'HGR',
                'name' => 'Hielera Grande',
                'category' => 3,
            ],
            [
                'code' => 'VC',
                'name' => 'Vasos de Vidrio',
                'category' => 4,
            ],
            [
                'code' => 'PL',
                'name' => 'Platos de Loza',
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
