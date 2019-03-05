<?php

use Illuminate\Database\Seeder;

class LogTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('log_types')->truncate();

        $log_types = [
            [
                'id' => 1,
                'name' => 'Login',
                'description' => 'Ha iniciado Sesión'
            ],
        ];

        foreach ($log_types as $log_type){
            DB::table('log_types')->insert([
                'id' =>  $log_type['id'],
                'name'  =>  $log_type['name'],
                'description' =>  $log_type['description'],
            ]);
        }
    }
}
