<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->truncate();


        $fields = [
            [
                'id' => 1,
                'name' => 'Conferencia General',
                'parent' => null
            ],
            [
                'id' => 2,
                'name' => 'División Sudamericana',
                'parent' => 1
            ],
            [
                'id' => 3,
                'name' => 'Unción Chilena',
                'parent' => 2
            ],
            [
                'id' => 4,
                'name' => 'Asociación Metropolitana',
                'parent' => 3
            ],
        ];

        foreach ($fields as $field){
            DB::table('fields')->insert([
                'id' => $field['id'],
                'name' => $field['name'],
                'parent_field_id' => $field['parent']
            ]);
        }
    }
}
