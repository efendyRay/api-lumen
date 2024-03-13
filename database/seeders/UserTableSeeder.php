<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name'       => 'User',
        	'phone'      => '08786336636363',
        	'email'      => 'user@gmail.com',
            'status'     => "Aktif",
        	'password'   => hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('user');

        $user = User::create([
        	'name'       => 'Admin',
            'phone'      => '0856666664643',
        	'email'      => 'admin@gmail.com',
            'status'     => "Aktif",
        	'password'   => hash::make('admin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user->assignRole('admin');
    }
}
