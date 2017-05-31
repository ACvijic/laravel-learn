<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Automobiles',
                'text' => "This is the automobiles category, go ahead, have a look 'round..",
                'image' => '/uploads/product-categories/automobiles.jpg',
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'Food',
                'text' => "This is the food category, go ahead, have a look 'round..",
                'image' => '/uploads/product-categories/food.jpg',
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'name' => 'IT',
                'text' => "This is the IT category, go ahead, have a look 'round..",
                'image' => '/uploads/product-categories/it.jpg',
                'visible' => 1,
                'deleted' => 0,
            ],
        ]);
    }
}
