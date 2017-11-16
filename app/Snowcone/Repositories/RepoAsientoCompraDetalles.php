<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 16/11/2017
 * Time: 14:51
 */

namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\AsientoCompraDetalles;

class RepoAsientoCompraDetalles extends Repo
{
    function getModel()
    {
        return new AsientoCompraDetalles();
    }
    public function createOrUpdate($data)
    {
        $asientocompradetalle = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $asientocompradetalle->fill($data);
        $asientocompradetalle->save();
        return $asientocompradetalle;
    }

    public function prepareData($asiento_compra_id,$dato)
    {
        $data = array();
        $data['id'] = '';
        $data['asiento_compra_id'] = $asiento_compra_id;
        $data['articulo_id'] = $dato['articulo_id'];
        $data['cantidad'] = $dato['cantidad'];
        return $data;
    }

    public function buscarxasiento($asiento_compra_id)
    {

        $model = $this->getModel();

        $model = $model->where('asiento_compra_id',$asiento_compra_id);

        $model = $model->get();

        return $model;
    }

}