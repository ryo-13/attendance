<?php

use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendances')->insert([
            'user_id' => 1,
            'date' => '2020-06-17',
            'arrival' => '07:10',
            'leave' => '17:10',
        ]);
    }
}
