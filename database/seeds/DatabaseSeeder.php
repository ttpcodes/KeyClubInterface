<?php

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
        $this->call(MembersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OfficersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
    }
}
