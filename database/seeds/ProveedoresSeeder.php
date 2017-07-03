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
            'descripcion' => 'Queen'
        ]);

        Proveedor::create([
            'descripcion' => 'Perello'
        ]);

        Proveedor::create([
            'descripcion' => 'Shelattino'
        ]);

        Proveedor::create([
            'descripcion' => 'Ice cream'
        ]);

        Proveedor::create([
            'descripcion' => 'Costa'
        ]);

        Proveedor::create([
            'descripcion' => 'Bonmi'
        ]);

        Proveedor::create([
            'descripcion' => 'Paty'
        ]);

        Proveedor::create([
            'descripcion' => 'Helado Gaby'
        ]);

        Proveedor::create([
            'descripcion' => 'Candy'
        ]);

        Proveedor::create([
            'descripcion' => 'Palitos Pablo'
        ]);

        Proveedor::create([
            'descripcion' => 'MC Cream'
        ]);

        Proveedor::create([
            'descripcion' => 'Mon Reve'
        ]);

        Proveedor::create([
            'descripcion' => 'Super(Candy)X 10 LTS'
        ]);

    }
}
