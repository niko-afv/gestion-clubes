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

        $members = [
            [
                'member_id' => 1,
                'position_id' => 1
            ],
            [
                'member_id' => 2,
                'position_id' => 1
            ],
            [
                'member_id' => 3,
                'position_id' => 1
            ],
            [
                'member_id' => 4,
                'position_id' => 1
            ],
            [
                'member_id' => 5,
                'position_id' => 1
            ],
        ];

        foreach ($members as $member){
            DB::table('member_positions')->insert([
                'member_id' => $member['member_id'],
                'position_id' => $member['position_id'],
            ]);
        }
    }
}
