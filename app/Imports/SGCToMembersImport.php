<?php

namespace App\Imports;

use App\Member;
use App\Position;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SGCToMembersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $oMember = new Member([
            'name' => ucwords(mb_strtolower($row['nombre'])),
            'dni' => $row['rut'],
            'email' => mb_strtolower($row['email']),
            'phone' => $row['telefono'],
            'institutable_id' => Auth::user()->member->institutable->id,
            'sgc_code' => $row['codigo_sgc'],
            'institutable_type' => 'App\\Club'
        ]);

        $oMember->save();
        //$res = $oMember->positions()->attach($row[4]);

        return $oMember;
    }
}
