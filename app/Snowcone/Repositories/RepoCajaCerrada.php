<?php
/**
 * User: damian
 * Date: 12/08/17
 * Time: 20:22
 */

namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\CajaCerrada;

class RepoCajaCerrada extends Repo {

    function getModel()
    {
        return new CajaCerrada();
    }

    public function prepareData()
    {
        $data = [];
        $data['id'] = '';
        $data['sucursal_id'] = env('APP_SUCURSAL',1);
        $data['user_id'] = \Auth::user()->id;
        $data['fecha'] = date("Y-m-d");

        return $data;


    }

    public function all()
    {
        $model = $this->getModel();

        $model = $model->where('cajas_cerradas.sucursal_id',env('APP_SUCURSAL',1));

        $model = $model->orderBy("cajas_cerradas.id","desc");

        $model = $model->with('user','presupuesto')->paginate(env('APP_CANT_PAGINATE',10));


        return $model;
    }

    public function getTotal($id)
    {
        $model = $this->getModel();

        $model = $model->join("presupuestos","presupuestos.caja_cerrada","=","cajas_cerradas.id");

        $model = $model->where('presupuestos.sucursal_id',env('APP_SUCURSAL',1));

        $model = $model->where("presupuestos.caja_cerrada",$id);

        $model = $model->where("presupuestos.estado_id",2);

        return $model->sum('presupuestos.precio_total');

    }

    public function getCantidad($id)
    {
        $model = $this->getModel();

        $model = $model->join("presupuestos","presupuestos.caja_cerrada","=","cajas_cerradas.id");

        $model = $model->where('presupuestos.sucursal_id',env('APP_SUCURSAL',1));

        $model = $model->where("presupuestos.caja_cerrada",$id);

        $model = $model->where("presupuestos.estado_id",2);

        return $model->count('presupuestos.caja_cerrada');

    }

//    public function find($id)
//    {
//        return $this->getModel()->find($id);
//    }

}