<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('positions')->truncate();


        $positions = [
            /*
            [
                'id' => 1,
                'name' => 'Director',
                'level' => 0
            ],
            [
                'id' => 2,
                'name' => 'Director Asociado',
                'level' => 1
            ],
            [
                'id' => 3,
                'name' => 'Capellán',
                'level' => 1
            ],
            [
                'id' => 4,
                'name' => 'Tesorero/a',
                'level' => 1
            ],
            [
                'id' => 5,
                'name' => 'Secretario/a',
                'level' => 1
            ],
            [
                'id' => 6,
                'name' => 'Instructor/a',
                'level' => 1
            ],
            [
                'id' => 7,
                'name' => 'Consejero/a',
                'level' => 1
            ],
            [
                'id' => 8,
                'name' => 'Capitán/a',
                'level' => 2
            ],
            [
                'id' => 9,
                'name' => 'Equipo de Apoyo',
                'level' => 1
            ],
            */
            [
                'id' => 10,
                'name' => 'Staff',
                'level' => 1
            ],
        ];

        foreach ($positions as $position){
            DB::table('positions')->insert([
                'id' => $position['id'],
                'name' => $position['name'],
                'level' => $position['level'],
                'description' => ''
            ]);
        }
    }
}
