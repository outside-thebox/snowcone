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

        $model = $model->groupBy('nro_factura')->paginate(env('APP_CANT_PAGINATE',10));


        return $model;
    }

    public function buscarboleta($id)
    {
        $model = $this->getModel();

        $model = $model->with('sucursal','proveedor','articulo','user');

        $model = $model->where('nro_factura',$id)->get();

        return $model;
    }
}