<?php

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
        // seed Users with a couple of "admin" accounts
        DB::table('users')->insert([
            'name' => 'Neil',
            'email' => 'neil.whitaker@gmail.com',
            'password' => bcrypt('password123'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name' => '9xb',
            'email' => 'admin@9xb.com',
            'password' => bcrypt('password123'),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
