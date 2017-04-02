<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('events')->insert([
            'name' => 'Creation of Key Club',
            'date' => date('Y-m-d', strtotime("1925-05-07")),
            'start' => date('H:i:s', strtotime('12:00AM')),
            'end' => date('H:i:s', strtotime('11:00PM')),
            'hours' => 23,
            'officer_id' => 1,
        ]);
    }
}
