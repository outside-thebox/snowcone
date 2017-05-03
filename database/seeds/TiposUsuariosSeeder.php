<?php

use App\Snowcone\Entities\TipoUsuario;
use Illuminate\Database\Seeder;

class TiposUsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUsuario::create([
            'descripcion' => 'Administrador'
        ]);

        TipoUsuario::create([
            'descripcion' => 'Gerente'
        ]);

        TipoUsuario::create([
            'descripcion' => 'Encargado'
        ]);

        TipoUsuario::create([
            'descripcion' => 'Puesto de ventas'
        ]);

        TipoUsuario::create([
            'descripcion' => 'Puesto de cajas'
        ]);
    }
}
