<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 27/07/17
 * Time: 18:31
 */
namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\StockXArticulo;
use Illuminate\Support\Facades\DB;

class RepoStockXArticulos extends Repo
{

    function getModel($connection = null)
    {
        $model = new StockXArticulo();
        if($connection)
        {
            $model->setConnection($connection);
            return $model;
        }

        return $model;
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

        $model = $model->where('articulos.deleted_at',null);

        $model = $model->join("proveedores","proveedores.id","=","articulos.proveedor_id");
        $model = $model->join("unidades_medida","unidades_medida.id","=","articulos.unidad_medida_id");

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));



//        $model = $model->with('unidad_medida','proveedor');

        $model = $model->select(['stockxarticulos.id','articulos.cod','articulos.id as articulo_id','articulos.descripcion','stockxarticulos.precio_compra'
            ,'stockxarticulos.precio_sugerido','stockxarticulos.stock','proveedores.descripcion as proveedor'
            ,'unidades_medida.descripcion as unidad_medida']);

        $model = $model->orderBy("articulos.cod");

        $model = $model->paginate(env('APP_CANT_PAGINATE',10));
        //$model = $model->get();

        return $model;

    }

    function findAll(array $datos)
    {


        if(isset($datos['conexion']))
            $model = $this->getModel($datos['conexion']);
        else
            $model = $this->getModel();

//        dd($model);


        $model = $model->leftJoin("articulos","articulos.id","=","stockxarticulos.articulo_id");

        if(isset($datos['cod']))
            $model = $model->where('articulos.cod',$datos['cod']);

        if(isset($datos['descripcion']))
            $model = $model->where('articulos.descripcion','like','%'.$datos['descripcion'].'%');

        if(isset($datos['proveedor_id']))
            $model = $model->where('articulos.proveedor_id',$datos['proveedor_id']);

        $model = $model->where('articulos.deleted_at',null);

        $model = $model->join("proveedores","proveedores.id","=","articulos.proveedor_id");
        $model = $model->join("unidades_medida","unidades_medida.id","=","articulos.unidad_medida_id");

        if(isset($datos['conexion']))
        {
            if($datos['conexion'] == "")
                $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));
        }

        if(isset($datos['stock']))
            $model = $model->where("stockxarticulos.stock",'>',0);

        $model = $model->select(['stockxarticulos.id','articulos.cod','articulos.id as articulo_id','articulos.descripcion','stockxarticulos.precio_compra'
            ,'stockxarticulos.precio_sugerido','stockxarticulos.stock','proveedores.descripcion as proveedor'
            ,'unidades_medida.descripcion as unidad_medida','sucursal_id']);

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

            $repoPresupuestoxArticulos = new RepoPresupuestoXArticulos();
            $presupuestosSinCobrar = $repoPresupuestoxArticulos->buscarPresupuestosSinCobrar();

            foreach($presupuestosSinCobrar as $presupuestoSinCobrar)
            {
                if($presupuestoSinCobrar->articulo_id == $l->articulo_id)
                {
                    $model->stock = $model->stock - $presupuestoSinCobrar->cantidad;
                }
            }


            if($model->stock < $l->cantidad)
                return $model;


        }
    }

    public function updateStock($id,$cantidad)
    {
        $model = $this->getModel()->where(['articulo_id' => $id]);

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));

        $model = $model->first();

        $model->stock = $model->stock - $cantidad;
        $model->save();
    }

    public function updateStockCancelPresupuesto($articulo_id,$cantidad)
    {
        $model = $this->getModel()->firstOrNew(['articulo_id' => $articulo_id,'sucursal_id' => ENV('APP_SUCURSAL',1)]);
        $model->stock = $model->stock + $cantidad;
        $model->save();
    }


    public function getListado()
    {
        $model = $this->getModel();

        $model = $model->join("articulos","articulos.id","=","stockxarticulos.articulo_id");

        $model = $model->where('articulos.deleted_at',null);

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));

        return $model->get();

    }

    public function getStockActual($articulo_id)
    {
        $model = $this->getModel();

        $model = $model->where("articulo_id",$articulo_id);

        $model = $model->where("stockxarticulos.sucursal_id",ENV('APP_SUCURSAL',1));

        $model = $model->select(['stock']);

        return $model->first()->stock;


    }

    public function updateStockRemoto($data)
    {
        $model = $this->getModel($data->conexion);


        $stockxarticulo = $model->find($data->stockxarticulos_id);
        $stockxarticulo->stock = $data->stock_nuevo;
        $stockxarticulo->precio_compra = $data->precio_compra_nuevo;
        $stockxarticulo->precio_sugerido = $data->precio_sugerido_nuevo;


        $stockxarticulo->save();
    }

}
