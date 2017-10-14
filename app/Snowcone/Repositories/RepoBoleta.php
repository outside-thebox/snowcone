<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 8/8/2017
 * Time: 12:09
 */

namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\Boleta;

class RepoBoleta  extends Repo{

    function getModel()
    {
        // TODO: Implement getModel() method.
        return new Boleta();
    }

    public function buscarAgrupadoBoleta()
    {
        $model = $this->getModel();

        $model = $model->with('sucursal','proveedor','articulo','user');

        $model = $model->orderBy('created_at', 'desc');

        $model = $model->groupBy('nro_factura','proveedor_id')->paginate(env('APP_CANT_PAGINATE',10));


        return $model;
    }

    public function buscarboleta($dato)
    {

        $model = $this->getModel();

        $model = $model->with('sucursal','proveedor','articulo','user');

        $model = $model->where('nro_factura',$dato['nro_factura']);

        $model = $model->where('proveedor_id',$dato['proveedor_id'])->get();

        return $model;
    }

    public function buscarboletaXArticulo($articulo_id)
    {

        $model = $this->getModel();

        $model = $model->where('articulo_id',$articulo_id);

        $model = $model->get();

        return $model;
    }


    public function validarboleta($proveedor_id, $nro_factura)
    {

        $model = $this->getModel();

        $model = $model->with('sucursal','proveedor','articulo','user');

        $model = $model->where('nro_factura',$nro_factura);

        $model = $model->where('proveedor_id',$proveedor_id)->get();

        return $model->isNotEmpty();

    }
}