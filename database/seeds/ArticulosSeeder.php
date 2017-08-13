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

        Articulo::create([
            'cod' => 1029,
            'descripcion' => 'Chocolate c/ pasas al rhum',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 29,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1030,
            'descripcion' => 'Chocolate c/ almendras',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 30,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1031,
            'descripcion' => 'Crema de almendra',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 31,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1032,
            'descripcion' => 'Banana split',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 32,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1033,
            'descripcion' => 'Tramontana',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 33,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1034,
            'descripcion' => 'Sambayón',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 34,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1035,
            'descripcion' => 'Tiramisú',
            'unidad_medida_id' => 1,
            'proveedor_id' => 3,
        ]);

        StockXArticulo::create([
            'articulo_id' => 35,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 240,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1036,
            'descripcion' => 'Chocolate c/ almendras',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 336,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1037,
            'descripcion' => 'Chocolate candy',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 37,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1038,
            'descripcion' => 'Choco torta',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 38,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1039,
            'descripcion' => 'Super dulce tentación',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 39,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1040,
            'descripcion' => 'Banana split',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 40,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1041,
            'descripcion' => 'Tramontanta',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 41,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1042,
            'descripcion' => 'Sambayón',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 42,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1043,
            'descripcion' => 'Mantecol',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 43,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1044,
            'descripcion' => 'Tiramisú',
            'unidad_medida_id' => 1,
            'proveedor_id' => 4,
        ]);

        StockXArticulo::create([
            'articulo_id' => 44,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 270,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1045,
            'descripcion' => 'Palito de agua x 40 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 45,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 35,
            'precio_sugerido' => 1.5
        ]);

        Articulo::create([
            'cod' => 1046,
            'descripcion' => 'Palito mini tirabuzón x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 46,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 38,
            'precio_sugerido' => 1.5
        ]);

        Articulo::create([
            'cod' => 1047,
            'descripcion' => 'Palito de agua 2 gustos (Marpe) x 40 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 47,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 75,
            'precio_sugerido' => 2.5
        ]);

        Articulo::create([
            'cod' => 1048,
            'descripcion' => 'Palito de crema x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 48,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 45,
            'precio_sugerido' => 2.5
        ]);

        Articulo::create([
            'cod' => 1049,
            'descripcion' => 'Palito bombon x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 49,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 3.5
        ]);

        Articulo::create([
            'cod' => 1050,
            'descripcion' => 'Banana Bom x 20 unid (Marpe)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 5,
        ]);

        StockXArticulo::create([
            'articulo_id' => 50,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 80,
            'precio_sugerido' => 6
        ]);

        Articulo::create([
            'cod' => 1051,
            'descripcion' => 'Pote 1.400 (3 gustos)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 51,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 22,
            'precio_sugerido' => 30
        ]);

        Articulo::create([
            'cod' => 1052,
            'descripcion' => 'Balde 3 LTS',
            'unidad_medida_id' => 1,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 52,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 50,
            'precio_sugerido' => 60
        ]);

        Articulo::create([
            'cod' => 1053,
            'descripcion' => 'Balde 5 LTS',
            'unidad_medida_id' => 1,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 53,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 40,
            'precio_sugerido' => 80
        ]);

        Articulo::create([
            'cod' => 1054,
            'descripcion' => 'Pote 360 cc (3 gustos) x 12 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 54,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 80,
            'precio_sugerido' => 10
        ]);

        Articulo::create([
            'cod' => 1055,
            'descripcion' => 'Tacita 90 cc (2 gustos) x 24 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 55,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 80,
            'precio_sugerido' => 5
        ]);

        Articulo::create([
            'cod' => 1056,
            'descripcion' => 'Taza 130 cc (2 gustos) x 24 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 6,
        ]);

        StockXArticulo::create([
            'articulo_id' => 56,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 100,
            'precio_sugerido' => 8
        ]);

        Articulo::create([
            'cod' => 1057,
            'descripcion' => 'Palito crema due (2 gustos) x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 57,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 75,
            'precio_sugerido' => 4
        ]);

        Articulo::create([
            'cod' => 1058,
            'descripcion' => 'Carita x 20 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 58,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 45,
            'precio_sugerido' => 7
        ]);

        Articulo::create([
            'cod' => 1059,
            'descripcion' => 'Palito bombón x 30 unid (Negro y blanco)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 59,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 5
        ]);

        Articulo::create([
            'cod' => 1060,
            'descripcion' => 'Palito bombón crocante x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 60,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 110,
            'precio_sugerido' => 6
        ]);

        Articulo::create([
            'cod' => 1061,
            'descripcion' => 'Palito alfajor bombón x 18 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 1061,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 110,
            'precio_sugerido' => 6
        ]);

        Articulo::create([
            'cod' => 1062,
            'descripcion' => 'Cono krok crocante x 14 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 62,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 100,
            'precio_sugerido' => 12
        ]);

        Articulo::create([
            'cod' => 1063,
            'descripcion' => 'Cono krok x 14 unid (Blanco)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 63,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 100,
            'precio_sugerido' => 12
        ]);

        Articulo::create([
            'cod' => 1064,
            'descripcion' => 'Cono krok x 14 unid (Americana)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 7,
        ]);

        StockXArticulo::create([
            'articulo_id' => 64,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 100,
            'precio_sugerido' => 12
        ]);

        Articulo::create([
            'cod' => 1065,
            'descripcion' => 'Agua especial x 40 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 65,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 40,
            'precio_sugerido' => 1.5
        ]);

        Articulo::create([
            'cod' => 1066,
            'descripcion' => 'Palito de crema x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 66,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 55,
            'precio_sugerido' => 3
        ]);

        Articulo::create([
            'cod' => 1067,
            'descripcion' => 'Palito bombón x 30 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 67,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 5
        ]);

        Articulo::create([
            'cod' => 1068,
            'descripcion' => 'Pote 360 cc (3 gustos) x 12 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 68,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 10
        ]);

        Articulo::create([
            'cod' => 1069,
            'descripcion' => 'Pote 360 cc Frutal (2 gustos) x 12 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 69,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 75,
            'precio_sugerido' => 9
        ]);

        Articulo::create([
            'cod' => 1070,
            'descripcion' => 'Tacita 90 cc (2 gustos) x 16 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 70,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 70,
            'precio_sugerido' => 6.5
        ]);

        Articulo::create([
            'cod' => 1071,
            'descripcion' => 'Pote 1.400 (4 gustos)',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 71,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 30,
            'precio_sugerido' => 30
        ]);

        Articulo::create([
            'cod' => 1072,
            'descripcion' => 'Pote x 1 LTS (3 gustos)',
            'unidad_medida_id' => 1,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 72,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 25,
            'precio_sugerido' => 30
        ]);

        Articulo::create([
            'cod' => 1073,
            'descripcion' => 'Balde 5 LTS',
            'unidad_medida_id' => 1,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 73,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 60,
            'precio_sugerido' => 70
        ]);

        Articulo::create([
            'cod' => 1074,
            'descripcion' => 'Balde 5 LTS',
            'unidad_medida_id' => 1,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 74,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 80,
            'precio_sugerido' => 95
        ]);

        Articulo::create([
            'cod' => 1075,
            'descripcion' => 'Tricolor x 24 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 75,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 135,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1076,
            'descripcion' => 'Almendrado x 24 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 76,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 160,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1077,
            'descripcion' => 'Bombón scoses x 6 unid',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 77,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1078,
            'descripcion' => 'Almendrado (Barra) x 10 porciones',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 78,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 95,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1079,
            'descripcion' => 'Bombón suizo',
            'unidad_medida_id' => 4,
            'proveedor_id' => 8,
        ]);

        StockXArticulo::create([
            'articulo_id' => 79,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 165,
            'precio_sugerido' => 0
        ]);

        Articulo::create([
            'cod' => 1080,
            'descripcion' => 'Cucharitas 100 grs',
            'unidad_medida_id' => 3,
            'proveedor_id' => 9,
        ]);

        StockXArticulo::create([
            'articulo_id' => 80,
            'sucursal_id' => env('APP_SUCURSAL',1),
            'stock' => 0,
            'precio_compra' => 12,
            'precio_sugerido' => 0
        ]);


    }
}
