<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name'       => 'user',
            'guard_name' => 'api'
        ]);
        
        $role = Role::create([
            'name'       => 'admin',
            'guard_name' => 'api'
        ]);
        
    }
}
