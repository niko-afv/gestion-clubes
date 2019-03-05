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
        /*
        $members = [
            [
                'dni' => '173908784',
                'name' => 'Nicolás Fredes',
                'email' => 'niko.afv@gmail.com',
                'phone' => '+56990628013',
                'birth_date'=> '1990-02-26',
                'club_id' => 1,
                'position_id' => 1
            ]
        ];

        foreach ($members as $member){
            DB::table('members')->insert([
                'dni' => $member['dni'],
                'name' => $member['name'],
                'email' => $member['email'],
                'phone' => $member['phone'],
                'birth_date'=> $member['birth_date'],
                'club_id' => $member['club_id']
            ]);
        }
        */
    }
}
