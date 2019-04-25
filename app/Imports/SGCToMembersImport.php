<?php

namespace App\Imports;

use App\Member;
use App\Position;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

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
        'TESOUREIRO DO CLUBE' => 4,
        'CONSELHEIRO ASSOCIADO' => 7,
        'AVENTUREIRO' => 9

    ];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row['cargo'] != 'DIRETOR DE CLUBE'){
            $query = Member::where('dni', $row['rut']);
            if($query->count()){
                return;
            }

            $oMember = new Member([
                'name' => ucwords(mb_strtolower($row['nombre'])),
                'dni' => $row['rut'],
                'email' => mb_strtolower($row['email']),
                'phone' => $row['telefono'],
                'birth_date' => Carbon::createFromFormat('d/m/Y',$row['fecha_nacimiento']),
                'institutable_id' => Auth::user()->member->institutable->id,
                'sgc_code' => $row['codigo_sgc'],
                'institutable_type' => 'App\\Club'
            ]);

            $oMember->save();
            if(!is_null($row['cargo']) && $row['cargo'] !== 'DESBRAVADOR'){
                $oMember->positions()->attach($this->postions_map[$row['cargo']]);
            }

            return $oMember;
        }
    }
}
