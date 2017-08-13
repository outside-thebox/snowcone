<?php

use App\Snowcone\Entities\Proveedor;
use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::create([
            'descripcion' => 'Comunes X 10 LTS'
        ]);

        Proveedor::create([
            'descripcion' => 'Especiales X 10 LTS'
        ]);

        Proveedor::create([
            'descripcion' => 'Premium X 10 LTS'
        ]);

        Proveedor::create([
            'descripcion' => 'Super premium X 10 LTS'
        ]);

        Proveedor::create([
            'descripcion' => 'Linea económica'
        ]);

        Proveedor::create([
            'descripcion' => 'Linea BON-MI y MON'
        ]);

        Proveedor::create([
            'descripcion' => 'Linea Perello'
        ]);

        Proveedor::create([
            'descripcion' => 'Linea Fri Crem'
        ]);

        Proveedor::create([
            'descripcion' => 'Otros'
        ]);

    }
}
