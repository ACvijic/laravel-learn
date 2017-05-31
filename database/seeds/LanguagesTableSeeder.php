<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            [
                'short_name' => 'srb',
                'name' => 'serbian',
                'priority' => 1,
            ],
            [
                'short_name' => 'en',
                'name' => 'english',
                'priority' => 2,
            ],
            [
                'short_name' => 'it',
                'name' => 'italian',
                'priority' => 3,
            ],
        ]);
    }
}
