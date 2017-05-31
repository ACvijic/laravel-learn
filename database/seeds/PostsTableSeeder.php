<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $client = new Client();
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/photos');
        
        $data = $response->getBody();
        $data = json_decode($data);
        
        if(count($data) > 0){
            for($i = 1; $i < 10; $i++){
                foreach ($data as $value) {
                    DB::table('posts')->insert([
                        'category' => 'Pice',
                        'title' => $value->title . $i,
                        'image' => $value->url,
                        'body' => $value->title . " " . $value->title . " " . $value->title,
                        'status' => 1
                    ]);
                }
            }
        }
        
        
        
//        DB::table('posts')->insert([
//            'category' => 'Pice',
//            'title' => 'Post o picu',
//            'image' => 'https://www.w3schools.com/css/trolltunga.jpg',
//            'body' => 'Ovo je tekst o picu Ovo je tekst o picuOvo je tekst o picu',
//            'status' => 1
//        ]);
//        DB::table('posts')->insert([
//            'category' => 'Pice',
//            'title' => 'Drugi post o picu',
//            'image' => 'https://www.w3schools.com/css/trolltunga.jpg',
//            'body' => 'Ovo je tekst o picu Ovo je tekst o picuOvo je tekst o picu',
//            'status' => 1
//        ]);
//        DB::table('posts')->insert([
//            'category' => 'Hrana',
//            'title' => 'Post o hrani',
//            'image' => 'https://www.w3schools.com/css/trolltunga.jpg',
//            'body' => 'Ovo je tekst o hrani Ovo je tekst o hrani Ovo je tekst o hrani',
//            'status' => 1
//        ]);
    }
}
