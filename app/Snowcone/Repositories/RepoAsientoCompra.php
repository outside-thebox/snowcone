<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 15:57
 */
namespace App\Snowcone\Repositories;



class RepoAsientoCompra extends Repo
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

}