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

    public function findAndPaginateStock(array $datos)
    {
        $model = $this->getModel();

        $model = $model->leftJoin("articulos","articulos.id","=","stockxarticulos.articulo_id");

        if(isset($datos['cod']))
            $model = $model->where('articulos.cod',$datos['cod']);

        if(isset($datos['descripcion']))
            $model = $model->where('articulos.descripcion','like','%'.$datos['descripcion'].'%');

        if(isset($datos['proveedor_id']))
            $model = $model->where('articulos.proveedor_id',$datos['proveedor_id']);

//        dd($datos['ingresados']);
        if(isset($datos['ingresados']))
            $model = $model->whereNotIn('articulos.cod',explode(",",$datos['ingresados']));

        $model = $model->join("proveedores","proveedores.id","=","articulos.proveedor_id");
        $model = $model->join("unidades_medida","unidades_medida.id","=","articulos.unidad_medida_id");

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));

//        $model = $model->with('unidad_medida','proveedor');

        $model = $model->select(['stockxarticulos.id','articulos.cod','articulos.id as articulo_id','articulos.descripcion','stockxarticulos.precio_compra'
            ,'stockxarticulos.precio_sugerido','stockxarticulos.stock','proveedores.descripcion as proveedor'
            ,'unidades_medida.descripcion as unidad_medida']);

        $model = $model->orderBy("articulos.cod");

        $model = $model->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }

    function findAll(array $datos)
    {
        $model = $this->getModel();

        $model = $model->leftJoin("articulos","articulos.id","=","stockxarticulos.articulo_id");

        if(isset($datos['cod']))
            $model = $model->where('articulos.cod',$datos['cod']);

        if(isset($datos['descripcion']))
            $model = $model->where('articulos.descripcion','like','%'.$datos['descripcion'].'%');

        if(isset($datos['proveedor_id']))
            $model = $model->where('articulos.proveedor_id',$datos['proveedor_id']);

        $model = $model->join("proveedores","proveedores.id","=","articulos.proveedor_id");
        $model = $model->join("unidades_medida","unidades_medida.id","=","articulos.unidad_medida_id");

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));

        $model = $model->select(['stockxarticulos.id','articulos.cod','articulos.id as articulo_id','articulos.descripcion','stockxarticulos.precio_compra'
            ,'stockxarticulos.precio_sugerido','stockxarticulos.stock','proveedores.descripcion as proveedor'
            ,'unidades_medida.descripcion as unidad_medida']);

        $model = $model->orderBy("articulos.cod");
        $model = $model->get();

        return $model;

    }

    public function update($data)
    {
        $record = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $record->fill($data);

        $record->save();
    }

    public function validateStock($lista)
    {
        foreach($lista as $l)
        {
            $model = $this->getModel()
                ->join('articulos','articulos.id','=','stockxarticulos.articulo_id')
                ->where('stockxarticulos.id',$l->id)->first();

//            dd($model);
            if($model->stock < $l->cantidad)
                return $model;


        }
    }

    public function updateStock($id,$l)
    {
        $model = $this->getModel()->firstOrNew(['id' => $id]);
        $model->stock = $model->stock - $l->cantidad;
        $model->save();
    }

}
