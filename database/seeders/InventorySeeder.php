<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $inventory =
        [
            [
                'name'   => 'test 1',
                'category'   => 'test',
                'quantity'       => '124',
                'location' => 'testets',
                'threshold'   => '1',
            ],

            [
                'name'   => 'test 2 ',
                'category'   => 'test',
                'quantity'       => '75',
                'location' => 'testets',
                'threshold'   => '5',
            ],

            [
                'name'   => 'test 3',
                'category'   => 'test',
                'quantity'       => '38',
                'location' => 'testets',
                'threshold'   => '10',
            ]
        ];
            DB::table('inventory_items')->insert($inventory);
    }
}
