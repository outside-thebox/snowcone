<?php

/**
 * Created by PhpStorm.
 * User: damián
 * Date: 06/08/2017
 * Time: 20:36
 */
namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\PresupuestoXArticulo;

class RepoPresupuestoXArticulos extends Repo
{

    function getModel()
    {
        return new PresupuestoXArticulo();
    }

    public function createOrUpdate($data)
    {
        $presupuestoxarticulo = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $presupuestoxarticulo->fill($data);
        $presupuestoxarticulo->save();
        return $presupuestoxarticulo;
    }

    public function prepareData($presupuesto_id, $l)
    {
        $data = array();

        $data['id'] = '';
        $data['presupuesto_id'] = $presupuesto_id;
        $data['articulo_id'] = $l->articulo_id;
        $data['cantidad'] = $l->cantidad;
        $data['precio_unitario'] = $l->precio_unitario;
        $data['subtotal'] = $l->subtotal;

        return $data;

    }

    public function presupuestoxarticulos($presupuesto_id)
    {
        $model = $this->getModel();

        $model = $model->where("presupuesto_id",$presupuesto_id);

        return $model->get();
    }

    public function buscarPresuestoXArticulo($articulo_id)
    {
        $model = $this->getModel();

        $model = $model->join("presupuestos","presupuestos.id","=","presupuestosxarticulos.presupuesto_id");

//        $model = $model->join("users","presupuestos.user_id","=","users.id");

        $model = $model->where("estado_id",2);

        $model = $model->where("articulo_id",$articulo_id);

        $model = $model->with("presupuesto.user");

        $model = $model->where("presupuestos.sucursal_id",ENV('APP_SUCURSAL',1));

//        $model = $model->select(['presupuestos.id as id','presupuestosxarticulos.cantidad','presupuestos.created_at','presupuestos.cliente', \DB::raw('concat(users.nombre," ",users.apellido) as nombre')]);

        return $model->get();
    }

    public function buscarPresupuestosSinCobrar()
    {

        $model = $this->getModel();

        $model = $model->join("presupuestos","presupuestos.id","=","presupuestosxarticulos.presupuesto_id");

        $model = $model->where("estado_id",1);

        $model = $model->where("presupuestos.sucursal_id",ENV('APP_SUCURSAL',1));

        return $model->get(['articulo_id','cantidad']);

    }


}