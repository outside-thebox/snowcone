<?php

use App\Snowcone\Entities\UnidadMedida;
use Illuminate\Database\Seeder;

class UnidadesMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedida::create([
            'descripcion' => 'Unidad de medida 1'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Unidad de medida 2'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Unidad de medida 3'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Unidad de medida 4'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Unidad de medida 5'
        ]);
    }
}
