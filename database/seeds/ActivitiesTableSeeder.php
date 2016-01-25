<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $length = 36;
        $activityData = [
            [
                'user_id' => 1,
                'lesson_id' => 1,
                'activity' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
                'type' => 1,
                'created_at' => date('Y-m-d G:i:s'),
                'updated_at' => date('Y-m-d G:i:s'),
            ],
            [
                'user_id' => 2,
                'lesson_id' => 2,
                'activity' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
                'type' => 1,
                'created_at' => date('Y-m-d G:i:s'),
                'updated_at' => date('Y-m-d G:i:s'),
            ],
            [
                'user_id' => 2,
                'lesson_id' => 3,
                'activity' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ , ."), 0, $length),
                'type' => 1,
                'created_at' => date('Y-m-d G:i:s'),
                'updated_at' => date('Y-m-d G:i:s'),
            ],
        ];

        DB::table('activities')->insert($activityData);
    }
}
