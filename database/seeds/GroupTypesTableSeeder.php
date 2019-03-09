<?php

use Illuminate\Database\Seeder;

class GroupTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_types')->truncate();

        $group_types = [
            [
                'id' => 1,
                'name' => 'Unidad'
            ],
            [
                'id' => 2,
                'name' => 'Directiva'
            ],
            [
                'id' => 3,
                'name' => 'Regional'
            ],
            [
                'id' => 4,
                'name' => 'Zonal'
            ],
        ];

        foreach ($group_types as $group_type){
            DB::table('group_types')->insert([
                'id' =>  $group_type['id'],
                'name'  =>  $group_type['name'],
                'description' =>  '',
            ]);
        }
    }
}
