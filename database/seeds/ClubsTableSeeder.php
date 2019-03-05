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

        DB::table('clubs')->insert([
            'id' => 1,
            'name' => 'Regional AMCH',
            'logo' => '',
            'photo'=> '',
            'field_id' => 1,
            'zone_id' => 1,
            'active' => 1
        ]);
    }
}
