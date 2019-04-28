<?php

use Illuminate\Database\Seeder;

class UnitsCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = \App\Unit::all();

        foreach ($units as $unit){
            do{
                $code  = '';
                $code .= strtoupper(substr($unit->club->name, '0','2'));
                $code .= rand(10,99);
                $code .= strtoupper(substr($unit->club->zone->name,0,2));
                var_dump($code);
            }while (\App\Unit::where('code',$code)->count() > 0);

            $unit->code = $code;
            $unit->save();
            //$unit->code =
        }
    }
}
