<?php

namespace App\Imports;

use App\Member;
use App\Position;
use Maatwebsite\Excel\Concerns\ToModel;

class MembersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'name' => ucwords(mb_strtolower($row[0])),
            'dni' => $row[1],
            'email' => mb_strtolower($row[2]),
            'phone' => $row[3],
            'club_id' => $row[5]
        ]);
    }
}
