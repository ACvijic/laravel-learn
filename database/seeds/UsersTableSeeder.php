<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Aleksandar Stanojevic',
            'email' => 'aleksandar.stanojevic@cubes.rs',
            'password' => bcrypt('cubes'),
            'address' => 'Bulevar Mihajla Pupina 181, Beograd',
            'phone' => '',
            'role' => 'administrator'
        ]);
    }
}
