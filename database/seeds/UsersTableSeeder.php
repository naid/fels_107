<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('admin'),
                'type' => 'admin',
            ],
            [
                'name' => 'aaa',
                'email' => 'aaa@aaa.com',
                'password' => bcrypt('aaa'),
                'type' => 'user',
            ],
            [
                'name' => 'bbb',
                'email' => 'bbb@aaa.com',
                'password' => bcrypt('aaa'),
                'type' => 'user',
            ],
            [
                'name' => 'ccc',
                'email' => 'ccc@aaa.com',
                'password' => bcrypt('aaa'),
                'type' => 'user',
            ],
            [
                'name' => 'ddd',
                'email' => 'ddd@aaa.com',
                'password' => bcrypt('aaa'),
                'type' => 'user',
            ],
        ];

        DB::table('users')->insert($userData);

    }
}
