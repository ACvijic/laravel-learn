<?php

use Illuminate\Database\Seeder,
    Faker\Factory as Faker,
    App\Model\Lesson,
    App\Model\Tag,
    Illuminate\Support\Facades\DB
;

class LessonTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        $lessonIds = Lesson::pluck('id')->toArray(); // [1, 2, 3, 4, 5, 6, ...]
        $tagIds = Tag::pluck('id')->toArray();
        
        foreach(range(1, 30) as $index){            
            Db::table('lesson_tag')->insert([
                'lesson_id' =>$faker->randomElement($lessonIds),
                'tag_id' =>$faker->randomElement($tagIds),
            ]);
        }
    }
}
