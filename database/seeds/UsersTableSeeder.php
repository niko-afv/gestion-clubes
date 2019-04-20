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
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'Nicolás Fredes',
            'email' => 'niko.afv@gmail.com',
            'password'=> Hash::make('benjamin13'),
            'profile_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'David Martin',
            'email' => 'david.martin.lope@gmail.com',
            'password'=> Hash::make('regionaldavid'),
            'profile_id' => 2
        ]);
    }
}
