<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=User::create([
            'first_name'=>'user',
                'last_name'=>'user',
             'email'=>'user@gmail.com',
              'password'=>bcrypt('user123'),
                'phone'=>'098765433'
]
        );
        $admin=User::create([
                'first_name'=>'admin',
                'last_name'=>'admin',
                'email'=>'admin@gmail.com',
                'password'=>bcrypt('admin123'),
                'phone'=>'098765433'
            ]
        );

        $office=User::create([
                'first_name'=>'officer',
                'last_name'=>'officer',
                'email'=>'office@gmail.com',
                'password'=>bcrypt('office123'),
                'phone'=>'098765433'
            ]
        );

        $user->attachRole('user');
        $office->attachRole('officer');
        $admin->attachRole('admin');




    }
}
