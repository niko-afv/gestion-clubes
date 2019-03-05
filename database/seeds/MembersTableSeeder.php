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
        DB::table('members')->truncate();

        DB::table('members')->insert([
            'dni' => '173908784',
            'name' => 'Nicolás Fredes',
            'email' => 'niko.afv@gmail.com',
            'phone' => '+56990628013',
            'birth_date'=> '1990-02-26',
            'club_id' => 1
        ]);
    }
}
