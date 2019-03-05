<?php

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->truncate();


        $zones = [
            [
                'id' => 1,
                'name' => 'Norte',
                'field_id' => 4
            ],
            [
                'id' => 2,
                'name' => 'Centro',
                'field_id' => 4
            ],
            [
                'id' => 3,
                'name' => 'Poniente',
                'field_id' => 4
            ],
            [
                'id' => 4,
                'name' => 'Oriente',
                'field_id' => 4
            ]
        ];

        foreach ($zones as $position){
            DB::table('zones')->insert([
                'id' => $position['id'],
                'name' => $position['name'],
                'field_id' => $position['field_id']
            ]);
        }
    }
}
