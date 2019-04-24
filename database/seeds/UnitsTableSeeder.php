<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->truncate();

        $groups = [];

        foreach ($groups as $group){
            DB::table('units')->insert([
                'id' =>  $group['id'],
                'name'  =>  $group['name'],
                'description' =>  '',
                'club_id' => $group['club_id'],
            ]);
        }
    }
}
