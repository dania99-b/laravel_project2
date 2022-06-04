<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user=Role::create([
            'name'=>'user',
            'display_name'=>'user',
            'description'=>'can do specific things'
        ]);
        $role_admin=Role::create([
            'name'=>'admin',
            'display_name'=>'admin',
            'description'=>'can do anything'
        ]);
        $role_officer=Role::create([
            'name'=>'officer',
            'display_name'=>'officer',
            'description'=>'can do specific things'
        ]);
    }
}
