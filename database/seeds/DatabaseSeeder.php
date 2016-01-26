<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(ActivitiesTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        Model::reguard();
    }
}
