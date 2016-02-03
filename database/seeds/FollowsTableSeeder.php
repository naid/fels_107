<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $followData = [
            [
                'follower_id' => 2,
                'followee_id' => 3,
            ],
            [
                'follower_id' => 2,
                'followee_id' => 4,
            ],
            [
                'follower_id' => 2,
                'followee_id' => 5,
            ],
            [
                'follower_id' => 3,
                'followee_id' => 5,
            ],
            [
                'follower_id' => 3,
                'followee_id' => 2,
            ],
        ];

        DB::table('follows')->insert($followData);
    }
}
