<?php

use Illuminate\Database\Seeder;
use App\Imports\ClubsImport;
use Illuminate\Support\Facades\App;
use \Maatwebsite\Excel\Excel;

class ClubsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $clubs = [
            [
                'id' => 1,
                'name' => 'Regional AMCH',
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => 4,
                'active' => 1
            ],

        ];
        foreach ($clubs as $club){
            DB::table('clubs')->insert([
                'id' => $club['id'],
                'name' => $club['name'],
                'logo' => '',
                'photo'=> '',
                'field_id' => 1,
                'zone_id' => $club['zone_id'],
                'active' => $club['active']
            ]);
        }
        */

        $excel = App::make(Excel::class);
        $excel->import(new ClubsImport(), storage_path('app/import/clubes_import.csv'));

    }
}
