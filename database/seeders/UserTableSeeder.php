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
        // anu.v@ecesistech.com
        // wlts@2015

        // for ($i = 1; $i <= 10; $i++)
        // {
        //     $users[] = [
        //         'email' => 'user'. $i .'@myapp.com',
        //         'password' => $password
        //     ];
        // }
        $users[] = [
            'Name'          => 'Admin',
            'email'         => 'admin@tth.com',
            'password'      => Hash::make('admin@123#'),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];

        User::insert($users);
    }
}