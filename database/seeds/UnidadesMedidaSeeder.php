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
            'descripcion' => 'LTR'
        ]);
        UnidadMedida::create([
            'descripcion' => 'KG'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Gr'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Unidad'
        ]);
        UnidadMedida::create([
            'descripcion' => 'Caja'
        ]);
    }
}
