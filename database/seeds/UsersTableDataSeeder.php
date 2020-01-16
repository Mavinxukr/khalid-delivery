<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('111111'),
            'phone'     => '000-000-00-00',
            'image'     => 'https://st3.depositphotos.com/7652440/14103/v/1600/depositphotos_141035396-stock-illustration-admin-rubber-stamp.jpg'
        ]);

        User::create([
            'first_name' => 'Edik',
            'last_name' => 'Mobile',
            'email' => 'ediksadon@gmail.com',
            'password' => bcrypt('111111'),
            'phone'     => '000-000-00-00'
        ]);


        User::create([
            'first_name' => 'Pasha',
            'last_name' => 'Mobile',
            'email' => 'pashaios@gmail.com',
            'password' => bcrypt('111111'),
            'phone'     => '000-000-00-00'
        ]);

        User::create([
            'first_name' => 'Denys',
            'last_name' => 'Web',
            'email' => 'denis@gmail.com',
            'password' => bcrypt('111111'),
            'phone'     => '000-000-00-00'
        ]);



    }
}
