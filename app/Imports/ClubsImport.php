<?php

namespace App\Imports;

use App\Club;
use App\Zone;
use Maatwebsite\Excel\Concerns\ToModel;

class ClubsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $zone_str = mb_split(' ', $row[1]);
        $zone = Zone::where('name','like','%'.$zone_str[1].'%')->first();
        return new Club([
            'name' => ucwords(mb_strtolower($row[0])),
            'logo' => '',
            'photo'=> '',
            'field_id' => 4,
            'zone_id' => $zone->id,
            'active' => 0
        ]);
    }
}
