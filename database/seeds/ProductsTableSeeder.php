<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'category_id' => 1,
                'name' => 'Automobile 1',
                'description' => "Generic auto description",
                'text' => "You should deffinetly check out this product!",
                'price' => 100,
                'discount' => 10,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 1,
                'name' => 'Automobile 2',
                'description' => "Generic auto description",
                'text' => "You should deffinetly check out this product!",
                'price' => 200,
                'discount' => 20,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 1,
                'name' => 'Automobile 3',
                'description' => "Generic auto description",
                'text' => "You should deffinetly check out this product!",
                'price' => 300,
                'discount' => 30,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 1,
                'name' => 'Automobile 4',
                'description' => "Generic auto description",
                'text' => "You should deffinetly check out this product!",
                'price' => 400,
                'discount' => 40,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 1,
                'name' => 'Automobile 5',
                'description' => "Generic auto description",
                'text' => "You should deffinetly check out this product!",
                'price' => 500,
                'discount' => 50,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 2,
                'name' => 'Food item 1',
                'description' => "Generic food description",
                'text' => "You should deffinetly check out this product!",
                'price' => 100,
                'discount' => 10,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 2,
                'name' => 'Food item 2',
                'description' => "Generic food description",
                'text' => "You should deffinetly check out this product!",
                'price' => 200,
                'discount' => 20,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 2,
                'name' => 'Food item 3',
                'description' => "Generic food description",
                'text' => "You should deffinetly check out this product!",
                'price' => 300,
                'discount' => 30,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 2,
                'name' => 'Food item 4',
                'description' => "Generic food description",
                'text' => "You should deffinetly check out this product!",
                'price' => 400,
                'discount' => 40,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 2,
                'name' => 'Food item 5',
                'description' => "Generic food description",
                'text' => "You should deffinetly check out this product!",
                'price' => 500,
                'discount' => 50,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 3,
                'name' => 'Tech gear 1',
                'description' => "Generic tech description",
                'text' => "You should deffinetly check out this product!",
                'price' => 100,
                'discount' => 10,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 3,
                'name' => 'Tech gear 2',
                'description' => "Generic tech description",
                'text' => "You should deffinetly check out this product!",
                'price' => 200,
                'discount' => 20,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 3,
                'name' => 'Tech gear 3',
                'description' => "Generic tech description",
                'text' => "You should deffinetly check out this product!",
                'price' => 300,
                'discount' => 30,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 3,
                'name' => 'Tech gear 4',
                'description' => "Generic tech description",
                'text' => "You should deffinetly check out this product!",
                'price' => 400,
                'discount' => 40,
                'visible' => 1,
                'deleted' => 0,
            ],
            [
                'category_id' => 3,
                'name' => 'Tech gear 5',
                'description' => "Generic tech description",
                'text' => "You should deffinetly check out this product!",
                'price' => 500,
                'discount' => 50,
                'visible' => 1,
                'deleted' => 0,
            ]
        ]);
    }
}
