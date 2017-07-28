<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 27/07/17
 * Time: 18:31
 */
namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\StockXArticulo;

class RepoStockXArticulos extends Repo
{

    function getModel()
    {
        return new StockXArticulo();
    }

    function getRecordsMissing()
    {
        $model = $this->getModel();

//        $model = $model->rightJoin("articulos","stockxarticulos.articulo_id","=","articulos.id");

        $param1 = env('APP_SUCURSAL',1);
        $model = $model->rightJoin('articulos', function($join) use($param1) {
                        $join->on('stockxarticulos.articulo_id', '=', 'articulos.id');
                        $join->on('sucursal_id', '=', \DB::raw($param1));
                    });

        $model = $model->whereRaw("(stockxarticulos.sucursal_id = ".env('APP_SUCURSAL',1)." or stockxarticulos.sucursal_id is null)");

        $model = $model->whereNull("stockxarticulos.id");

        $model = $model->select(['articulos.id'])->get();

        return $model;
    }

    public function addRecords($array_missing)
    {
        foreach($array_missing as $record)
        {
            $this->getModel()->create([
                'articulo_id' => $record->id,
                'sucursal_id' => env('APP_SUCURSAL',1),
                'stock' => 0,
                'precio_compra' => 0,
                'precio_sugerido' => 0
            ]);
        }



    }

}
