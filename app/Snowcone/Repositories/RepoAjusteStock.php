<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 27/07/17
 * Time: 18:31
 */
namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\AjusteStock;

class RepoAjusteStock extends Repo
{

    function getModel($connection = null)
    {
        $model = new AjusteStock();
        if ($connection) {
            $model->setConnection($connection);
            return $model;
        }

        return $model;
    }

    public function createOrUpdate($data,$connection = null)
    {

        $entity = $this->getModel($connection)->firstOrNew(['id' => $data['id']]);

        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    public function findAndPaginate(array $datos)
    {
        $model = $this->getModel();

        if(isset($datos['sucursal_id']))
            $model = $model->where('sucursal_id',$datos['sucursal_id']);
        if(isset($datos['fecha']))
            $model = $model->whereDate('created_at', '=', $datos['fecha']);

        $model = $model->with('sucursal','user')->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }
}