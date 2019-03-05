<?php

use Illuminate\Database\Seeder;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clubs')->truncate();

        $clubs = [
            [
                'id' => 1,
                'name' => 'Regional AMCH',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 4,
                'active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Porvenir',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 4,
                'active' => 0
            ],
            [
                'id' => 3,
                'name' => 'Alameda',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 2,
                'active' => 0
            ],
            [
                'id' => 4,
                'name' => 'Exploradores',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 2,
                'active' => 0
            ],
            [
                'id' => 5,
                'name' => 'Aguila Fiel',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 3,
                'active' => 0
            ],

        ];

        foreach ($clubs as $club){
            DB::table('clubs')->insert([
                'id' => $club['id'],
                'name' => $club['name'],
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => $club['zone_id'],
                'active' => $club['active']
            ]);
        }
    }
}
