<?php

use Illuminate\Database\Seeder;

class ActivityCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activity_categories')->truncate();


        $categories = [
            [
                'id' => 1,
                'name' => 'Espirituales',
                'description' => 'Actividades Espirituales',
                'code' => 'AC01ES'
            ],
            [
                'id' => 2,
                'name' => 'Técnicas',
                'description' => 'Actividades Técnicas',
                'code' => 'AC02TE'
            ],
            [
                'id' => 3,
                'name' => 'Recreativas',
                'description' => 'Actividades Recreativas',
                'code' => 'AC03RE'
            ],
            [
                'id' => 4,
                'name' => 'Concursos',
                'description' => 'Concursos',
                'code' => 'AC04CO'
            ],
        ];

        foreach ($categories as $category){
            DB::table('activity_categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'description' => $category['description'],
                'code' => $category['code'],
            ]);
        }
    }
}
