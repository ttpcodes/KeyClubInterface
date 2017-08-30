<?php

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
        DB::table('users')->insert([
            [
                'name' => 'Sir Seal',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
                'member_id' => 1
            ],
            [
                'name' => 'Key Clubber',
                'email' => 'notadmin@notadmin.com',
                'password' => bcrypt('notadmin'),
                'member_id' => 2
            ]
        ]);
    }
}
