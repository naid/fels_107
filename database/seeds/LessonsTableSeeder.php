<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $lessonData = [
            [
                'user_id' => 2,
                'category_id' => 1,
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
            ],
            [
                'user_id' => 2,
                'category_id' => 3,
            ],
        ];

        DB::table('lessons')->insert($lessonData);

    }
}
