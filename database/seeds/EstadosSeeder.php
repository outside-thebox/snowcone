<?php

use App\Snowcone\Entities\Estado;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Estado::create([
//           'descripcion' => 'No Cobrado'
//        ]);
//        Estado::create([
//            'descripcion' => 'Cobrado'
//        ]);
        Estado::create([
            'descripcion' => 'Cancelado'
        ]);
    }
}
