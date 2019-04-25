<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use App\Imports\MembersImport;
use \Maatwebsite\Excel\Excel;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $members = [
            [
                'id' => 1,
                'name' => 'David Martin',
                'institutable_id' => 4,
                'institutable_type' => 'App\\Field',

                'active' => 1
            ],

        ];
        foreach ($members as $member){
            DB::table('members')->insert([
                'id' => $member['id'],
                'name' => $member['name'],
                'institutable_id' => $member['institutable_id'],
                'institutable_type' => $member['institutable_type'],
                'active' => $member['active']
            ]);
        }
        */

        $excel = App::make(Excel::class);
        $excel->import(new MembersImport(), storage_path('app/import/members_import.csv'));
    }
}
