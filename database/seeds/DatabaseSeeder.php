<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersSeeder::class);
         $this->call(TiposUsuariosSeeder::class);
         $this->call(UnidadesMedidaSeeder::class);
         $this->call(ArticulosSeeder::class);
         $this->call(ProveedoresSeeder::class);
         $this->call(SucursalesSeeder::class);
         $this->call(EstadosSeeder::class);
    }
}
