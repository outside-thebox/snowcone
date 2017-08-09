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
}