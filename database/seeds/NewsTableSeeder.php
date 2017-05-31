<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_contents')->insert([
            [
                'news_id' => 1,
                'language_id' => 1,
                'title' => "Generic title for article n1 in lang1",
                'description' => "Generic description for article n1 in lang1",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 1,
                'language_id' => 2,
                'title' => "Generic title for article n1 in lang2",
                'description' => "Generic description for article n1 in lang2",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 1,
                'language_id' => 3,
                'title' => "Generic title for article n1 in lang3",
                'description' => "Generic description for article n1 in lang3",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 2,
                'language_id' => 1,
                'title' => "Generic title for article n2 in lang1",
                'description' => "Generic description for article n2 in lang1",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 2,
                'language_id' => 2,
                'title' => "Generic title for article n2 in lang2",
                'description' => "Generic description for article n2 in lang2",
                'text' => '1Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 2,
                'language_id' => 3,
                'title' => "Generic title for article n2 in lang3",
                'description' => "Generic description for article n2 in lang3",
                'text' => '1Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 3,
                'language_id' => 1,
                'title' => "Generic title for article n3 in lang1",
                'description' => "Generic description for article n3 in lang1",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 3,
                'language_id' => 2,
                'title' => "Generic title for article n3 in lang2",
                'description' => "Generic description for article n3 in lang2",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ],
            [
                'news_id' => 3,
                'language_id' => 3,
                'title' => "Generic title for article n3 in lang3",
                'description' => "Generic description for article n3 in lang3",
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'seo_title' => 'Lorem ipsum',
                'seo_description' => 'Lorem ipsum',
                'seo_keywords' => 'Lorem ipsum',
                'visible' => 1,
                'publish_date' => Carbon::parse('2017-5-21')
            ]
        ]);
    }
}
