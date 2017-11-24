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
}