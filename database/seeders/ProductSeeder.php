<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('products')->insert([
        [
        	'name'       => 'Product 001',
        	'code'       => 'P0001',
        	'price'      => 20000,
            'status'     => "Ready",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
        	'name'       => 'Product 002',
        	'code'       => 'P0002',
        	'price'      => 10000,
            'status'     => "Ready",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
        	'name'       => 'Product 003',
        	'code'       => 'P0003',
        	'price'      => 70000,
            'status'     => "Ready",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
        	'name'       => 'Product 004',
        	'code'       => 'P0004',
        	'price'      => 670000,
            'status'     => "Ready",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [
        	'name'       => 'Product 005',
        	'code'       => 'P0005',
        	'price'      => 40000,
            'status'     => "Ready",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]
       ]);
    }
}
