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
            'password'=> Hash::make('benjamin13')
        ]);
    }
}
