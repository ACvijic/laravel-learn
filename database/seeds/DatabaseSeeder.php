<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     *
     * @var array
     */
    private $tables = [
        'lesson_tag',
        'lessons',
        'tags',
        'users'
    ];

    /**
     * Disables foreign key checks temporarily and truncates tables
     */
    private function cleanDatabase(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        foreach($this->tables as $tableName){
            DB::table($tableName)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->cleanDatabase();
//        
//        $this->call(TagsTableSeeder::class);
//        $this->call(LessonsTableSeeder::class);
//        $this->call(LessonTagTableSeeder::class);
        
        $this->call(LanguagesTableSeeder::class);
    }
}
