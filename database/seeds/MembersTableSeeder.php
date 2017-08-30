<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            [
                'id' => 1,
                'first' => 'Key',
                'last' => 'Clubber',
                'nickname' => 'Sir Seal',
                'suffix' => 'Admin',
                'email' => 'admin@admin.com',
                'address1' => '3636 Woodview Trace',
                'address2' => 'classified',
                'city' => 'Indianapolis',
                'country' => 'United States',
                'state' => 'Indiana',
                'postal' => '46248',
                'graduation' => '2020',
                'phone' => '1-317-875-8755',
                'birth' => date("1925-5-7"),
                'gender' => 'male',
            ],
            [
                'id' => 2,
                'first' => 'Key',
                'last' => 'Clubber',
                'nickname' => null,
                'suffix' => null,
                'email' => 'notadmin@notadmin.com',
                'address1' => '3636 Woodview Trace',
                'address2' => null,
                'city' => 'Indianapolis',
                'country' => 'United States',
                'state' => 'Indiana',
                'postal' => '46248',
                'graduation' => '2020',
                'phone' => '1-317-875-8755',
                'birth' => date("1925-5-7"),
                'gender' => 'male',
            ]
        ]);
    }
}
