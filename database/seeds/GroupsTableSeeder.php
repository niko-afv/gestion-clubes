<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->truncate();

        $groups = [
            [
                'id' => 1,
                'name' => 'Colmillo Blanco',
                'groupable_id' => 18,
                'type_id' => 1,
                'groupable_type' => 'App\\Club'
            ],
            [
                'id' => 2,
                'name' => 'Regional AMCH',
                'groupable_id' => 4,
                'type_id' => 3,
                'groupable_type' => 'App\\Field'
            ],
        ];

        foreach ($groups as $group){
            DB::table('groups')->insert([
                'id' =>  $group['id'],
                'name'  =>  $group['name'],
                'description' =>  '',
                'type_id' => $group['type_id'],
                'groupable_id' => $group['groupable_id'],
                'groupable_type' => $group['groupable_type']
            ]);
        }
    }
}
