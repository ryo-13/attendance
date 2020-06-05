<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            'name' => 'admin',
            'email' => 'admin@a.com',
            'password' => Hash::make('pass'),
            'remember_token' => Str::random(10),
        ]);
    }
}
