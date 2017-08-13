<?php

use App\Snowcone\Entities\Articulo;
use App\Snowcone\Entities\StockXArticulo;
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
        Articulo::create([
            'cod' => 1001,
            'descripcion' => 'Frutilla al agua',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 1,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1002,
            'descripcion' => 'Durazno',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 2,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1003,
            'descripcion' => 'Naranja',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 3,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1004,
            'descripcion' => 'Ananá',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 4,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1005,
            'descripcion' => 'Limón',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 5,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1006,
            'descripcion' => 'Frutilla a la crema',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 6,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1007,
            'descripcion' => 'Dulce de leche',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 7,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1008,
            'descripcion' => 'Crema del cielo',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 8,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1009,
            'descripcion' => 'Americana',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 9,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1010,
            'descripcion' => 'Vainilla',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 10,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1011,
            'descripcion' => 'Banana',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 11,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1012,
            'descripcion' => 'Frutilla al agua',
            'unidad_medida_id' => 1,
            'proveedor_id' => 1,
        ]);

        StockXArticulo::create([
            'articulo_id' => 12,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 190,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1013,
            'descripcion' => 'Chocolate',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 13,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1014,
            'descripcion' => 'Chocolate suizo',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 14,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1015,
            'descripcion' => 'Chocolate blanco',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 15,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1016,
            'descripcion' => 'Chocolate c/ dulce de leche',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 16,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1017,
            'descripcion' => 'Dulce granizado',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 17,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1018,
            'descripcion' => 'Flan c/ dulce de leche',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 18,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1019,
            'descripcion' => 'Menta granizada',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 19,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1020,
            'descripcion' => 'Limón granizado',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 20,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1021,
            'descripcion' => 'Crema oreo',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 21,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1022,
            'descripcion' => 'Frutilla a la reina',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 22,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1023,
            'descripcion' => 'Frutos del bosque',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 23,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1024,
            'descripcion' => 'Cereza a la crema',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 24,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1025,
            'descripcion' => 'Bananita dolca',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 25,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1026,
            'descripcion' => 'Kinotos al wiski',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 26,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1027,
            'descripcion' => 'Pistacho',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 27,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1028,
            'descripcion' => 'Baldes x 3 sabores (Frutilla/chocolate y vainilla)',
            'unidad_medida_id' => 1,
            'proveedor_id' => 2,
        ]);

        StockXArticulo::create([
            'articulo_id' => 28,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 210,
            'precio_sugerido' => 0
        ]);


    }
}
