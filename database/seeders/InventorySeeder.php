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
                'name'   => 'test',
                'category'   => 'test',
                'quantity'       => 'test',
                'location' => 'testets',
                'threshold'   => 'test',
            ],

            [
                'name'   => 'test',
                'category'   => 'test',
                'quantity'       => 'test',
                'location' => 'testets',
                'threshold'   => 'test',
            ],

            [
                'name'   => 'test',
                'category'   => 'test',
                'quantity'       => 'test',
                'location' => 'testets',
                'threshold'   => 'test',
            ]
        ];
            DB::table('inventory_items')->insert($inventory);
    }
}
