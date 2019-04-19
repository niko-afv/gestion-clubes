<?php

use Illuminate\Database\Seeder;

class MemberPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('member_positions')->truncate();

    }
}
