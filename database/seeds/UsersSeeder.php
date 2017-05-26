<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'nombre' => 'Usuario',
            'apellido' => 'Administrador',
            'dni' => 'administrador',
            'password' => bcrypt('123456'),
            'telefono' => '',
            'tipo_usuario_id' => 1,
        ]);

        for($i = 1;$i < 100;$i++)
        {
            User::create([
                'nombre' => $faker->name,
                'apellido' => $faker->lastName,
                'dni' => $faker->unique()->userName,
                'password' => bcrypt('123456'),
                'telefono' => $faker->tollFreePhoneNumber,
                'tipo_usuario_id' => $faker->randomElement([2,3,4,5])
            ]);
        }


    }
}
