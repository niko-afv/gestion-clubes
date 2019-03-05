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

        $members = [
            [
                'dni' => '173908784',
                'name' => 'Nicolás Fredes',
                'email' => 'niko.afv@gmail.com',
                'phone' => '+56990628013',
                'birth_date'=> '1990-02-26',
                'club_id' => 1,
                'position_id' => 1
            ],
            [
                'dni' => '111111111',
                'name' => 'Asdf Qwerty',
                'email' => 'email@gmail.com',
                'phone' => '+56912345678',
                'birth_date'=> '1990-02-26',
                'club_id' => 2,
                'position_id' => 1
            ],
            [
                'dni' => '111111111',
                'name' => 'Asdf Qwerty',
                'email' => 'email@gmail.com',
                'phone' => '+56912345678',
                'birth_date'=> '1990-02-26',
                'club_id' => 3,
                'position_id' => 1
            ],
            [
                'dni' => '111111111',
                'name' => 'Asdf Qwerty',
                'email' => 'email@gmail.com',
                'phone' => '+56912345678',
                'birth_date'=> '1990-02-26',
                'club_id' => 4,
                'position_id' => 1
            ],
            [
                'dni' => '111111111',
                'name' => 'Asdf Qwerty',
                'email' => 'email@gmail.com',
                'phone' => '+56912345678',
                'birth_date'=> '1990-02-26',
                'club_id' => 5,
                'position_id' => 1
            ],
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
    }
}
