<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Usuario',
            'apellido' => 'Administrador',
            'dni' => 'administrador',
            'password' => bcrypt('123456'),
            'telefono' => '',
            'tipo_usuario_id' => 1,
        ]);

    }
}
