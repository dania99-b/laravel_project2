<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $register_office = Permission::create([
            'name' => 'register_office',
            'display_name' => 'register_office', // optional
            'description' => 'register new office to database', // optional
        ]);
    }
}
