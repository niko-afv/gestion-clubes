<?php

use Illuminate\Database\Seeder;

class LogTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('log_types')->truncate();

        $log_types = [
            [
                'id' => 1,
                'name' => 'Login',
                'description' => 'Ha iniciado Sesión'
            ],
            [
                'id' => 2,
                'name' => 'Add Member',
                'description' => 'Ha añadido un nuevo miembro'
            ],
            [
                'id' => 3,
                'name' => 'Update Member',
                'description' => 'Ha modificado un miembro'
            ],
            [
                'id' => 4,
                'name' => 'Delete Member',
                'description' => 'Ha eliminado un niembro'
            ],
            [
                'id' => 5,
                'name' => 'Import Member',
                'description' => 'Ha importado nuevos miembros'
            ],
            [
                'id' => 6,
                'name' => 'Create Unit',
                'description' => 'Ha creado una nueva unidad'
            ],
            [
                'id' =>7,
                'name' => 'Update Unit',
                'description' => 'Ha modificado una unidad'
            ],
            [
                'id' => 8,
                'name' => 'Delete unit',
                'description' => 'Ha eliminado una unidad'
            ],
            [
                'id' => 9,
                'name' => 'Create Event',
                'description' => 'Ha creado un nuevo evento'
            ],
            [
                'id' => 10,
                'name' => 'Update Event',
                'description' => 'Ha actualizado un evento'
            ],
            [
                'id' => 11,
                'name' => 'Delete Event',
                'description' => 'Ha eliminado un evento'
            ],
            [
                'id' => 12,
                'name' => 'Activate Event',
                'description' => 'Ha activado un evento'
            ],
            [
                'id' => 13,
                'name' => 'Deactivate Event',
                'description' => 'Ha desactivado un evento'
            ],
            [
                'id' => 14,
                'name' => 'Activate User',
                'description' => 'Ha activado un usuario'
            ],
            [
                'id' => 15,
                'name' => 'Deactivate User',
                'description' => 'Ha desactivado un usuario'
            ],
            [
                'id' => 16,
                'name' => 'User Added',
                'description' => 'Ha añadido un nuevo usuario'
            ],
            [
                'id' => 17,
                'name' => 'Create Club',
                'description' => 'Ha creado un nuevo Club'
            ],
            [
                'id' => 18,
                'name' => 'Update Club',
                'description' => 'Ha modificado un Club'
            ],
            [
                'id' => 19,
                'name' => 'Add Club Director',
                'description' => 'Ha añadido un director de club'
            ],
            [
                'id' => 20,
                'name' => 'Remove Club Director',
                'description' => 'Ha removido un miembro como director de club'
            ],
            [
                'id' => 21,
                'name' => 'New Payment',
                'description' => 'Ha realizado un nuevo pago'
            ],
            [
                'id' => 22,
                'name' => 'Remove Payment',
                'description' => 'Ha eliminado un pago'
            ],
        ];

        foreach ($log_types as $log_type){
            DB::table('log_types')->insert([
                'id' =>  $log_type['id'],
                'name'  =>  $log_type['name'],
                'description' =>  $log_type['description'],
            ]);
        }
    }
}
