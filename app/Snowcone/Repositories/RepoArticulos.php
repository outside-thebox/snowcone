<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/05/17
 * Time: 00:07
 */
namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\Articulo;

class RepoArticulos extends Repo {

    function getModel()
    {
        return new Articulo();
    }

    public function prepareData($data)
    {
        $data['fecha_ultima_compra'] = date('Y-m-d');

        return $data;
    }

    public function findAndPaginate(array $datos)
    {
        $model = $this->getModel();

        if(isset($datos['cod']))
            $model = $model->where('cod',$datos['cod']);
        if(isset($datos['descripcion']))
            $model = $model->where('descripcion','like','%'.$datos['descripcion'].'%');

        $model = $model->with('unidad_medida','proveedor')->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }





}