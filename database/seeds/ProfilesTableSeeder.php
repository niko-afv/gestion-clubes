<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->truncate();


        $profiles = [
            [
                'id' => 1,
                'name' => 'Director Regional',
                'level' => 1
            ],
            [
                'id' => 2,
                'name' => 'Secretario Regional',
                'level' => 1
            ],
            [
                'id' => 3,
                'name' => 'Regional de Zona',
                'level' => 2
            ],
            [
                'id' => 4,
                'name' => 'Director de Club',
                'level' => 3
            ],
            [
                'id' => 5,
                'name' => 'Secretario de Club',
                'level' => 3
            ],
            [
                'id' => 6,
                'name' => 'Administrador',
                'level' => -1
            ],
        ];

        foreach ($profiles as $position){
            DB::table('profiles')->insert([
                'id' => $position['id'],
                'name' => $position['name'],
                'level' => $position['level'],
                'description' => ''
            ]);
        }
    }
}
