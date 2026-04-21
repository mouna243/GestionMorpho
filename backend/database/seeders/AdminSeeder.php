<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@.com',
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            'role' => 'admin',
            'age' => 25,
            'CIN' => 'K125478',
            'telephon' => '+212 63214-5879',
        ]);

    }
}
