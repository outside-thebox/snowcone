<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 7/5/2017
 * Time: 11:19
 */
namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\Sucursales;

class RepoSucursales extends Repo {

    function getModel()
    {
        return new Sucursales();
    }

    public function createOrUpdate($data)
    {
        $sucursal = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $sucursal->fill($data);
        $sucursal->save();
        return $sucursal;
    }
}