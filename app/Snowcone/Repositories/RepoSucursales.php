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

    public function findAndPaginate(array $datos)
    {
        $model = $this->getModel();

        if(isset($datos['nombre']))
            $model = $model->where('nombre','like','%'.$datos['nombre'].'%');
        if(isset($datos['direccion']))
            $model = $model->where('direccion','like','%'.$datos['direccion'].'%');

        $model = $model->withTrashed()->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }
    public function activar($id)
    {
        $this->getModel()->withTrashed()->find($id)->update(['deleted_at' => null]);
    }

    public function all()
    {
        return $this->getModel()->where('id','<>',1)->get();
    }


}