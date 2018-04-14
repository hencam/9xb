<?php

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
        // seed the roles
        DB::table('roles')->insert([
            'job_role' => 'Developer',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')            
        ]);

        DB::table('roles')->insert([
            'job_role' => 'Project Manager',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
