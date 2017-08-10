<?php

use App\Snowcone\Entities\Articulo;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class ArticulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 1;$i < 1000;$i++)
        {
            Articulo::create([
                'cod' => $i,
                'descripcion' => $faker->address,
                'unidad_medida_id' => $faker->randomElement([1,2,3,4,5]),
                'fecha_ultima_compra' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'proveedor_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13]),

            ]);
        }
    }
}
