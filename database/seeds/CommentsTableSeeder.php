<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            [
                'email' => 'john@doe.com',
                'title' => 'For product',
                'text' => "You should deffinetly check out this product!",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
            [
                'email' => 'john@doe.com',
                'title' => 'For product',
                'text' => "You should deffinetly check out this product!",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
            [
                'email' => 'john@doe.com',
                'title' => 'For product',
                'text' => "You should deffinetly check out this product!",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
            [
                'email' => 'john@doe.com',
                'title' => 'For comment',
                'text' => "You should shut up!",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
            [
                'email' => 'john@doe.com',
                'title' => 'For comment',
                'text' => "No,you should shut up !",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
            [
                'email' => 'john@doe.com',
                'title' => 'For comment',
                'text' => "Shut it!",
                'product_id' => 1,
                'comment_id' => 0,
                'number_of_likes' => 0,
                'banned' => 0,
                'reported' => 0,
            ],
        ]);
    }
}
