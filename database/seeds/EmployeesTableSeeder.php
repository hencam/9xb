<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed the Employees
        DB::table('employees')->insert([
            'firstname' => 'Jo',
            'lastname' => 'Strummer',
            'email' => 'mail+j+strummer@9xb.com',
            'role_id' => '1',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('employees')->insert([
            'firstname' => 'Mick',
            'lastname' => 'Jones',
            'email' => 'mail+m+jones@9xb.com',
            'role_id' => '2',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('employees')->insert([
            'firstname' => 'Pauline',
            'lastname' => 'Black',
            'email' => 'mail+p+black@9xb.com',
            'role_id' => '1',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('employees')->insert([
            'firstname' => 'Topper',
            'lastname' => 'Headon',
            'email' => 'mail+t+headon@9xb.com',
            'role_id' => '1',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
