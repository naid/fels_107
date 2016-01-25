<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $length = 36;
        $categoryData = [
            [
                'name' => 'Category 1',
                'image' => '',
                'description' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
            ],
            [
                'name' => 'Category 2',
                'image' => '',
                'description' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
            ],
            [
                'name' => 'Category 3',
                'image' => '',
                'description' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
            ],
        ];

        DB::table('categories')->insert($categoryData);
    }
}
