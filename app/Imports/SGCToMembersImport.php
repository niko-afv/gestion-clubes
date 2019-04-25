<?php

namespace App\Imports;

use App\Member;
use App\Position;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SGCToMembersImport implements ToModel, WithHeadingRow
{

    private $postions_map = [
        'APOIO' => 9,
        'DESBRAVADOR' => null,
        'CONSELHEIRO' => 7,
        'DIRETOR DE CLUBE' => 1,
        'INSTRUTOR' => 6,
        'DIRETOR ASSOCIADO' => 2,
        'CAPELÃO DO CLUBE' => 3,
        'SECRETÁRIO DO CLUBE' => 5,
        'TESOUREIRO DO CLUBE' => 4
    ];

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
        if($row['cargo'] !== 'DESBRAVADOR'){
            $oMember->positions()->attach($this->postions_map[$row['cargo']]);
        }

        return $oMember;
    }
}
