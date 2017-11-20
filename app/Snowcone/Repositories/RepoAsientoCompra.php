<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 15:57
 */
namespace App\Snowcone\Repositories;



use App\Snowcone\Entities\AsientoCompra;

class RepoAsientoCompra extends Repo
{
    function getModel($connection = null)
    {
        return new AsientoCompra();

    }
    public function createOrUpdate($data)
    {
        $asientocompra = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $asientocompra->fill($data);
        $asientocompra->save();
        return $asientocompra;
    }

    public function store($dato)
    {
        $lista = $dato['row'];
        $asientocompra = $this->createOrUpdate($this->prepareData($dato));

        foreach($lista as $l)
        {
            if($l['cantidad']) {
                $data = $this->getRepoAsientoCompraDetalles()->prepareData($asientocompra['id'], $l);
                $this->getRepoAsientoCompraDetalles()->createOrUpdate($data);
            }
        }

        return $asientocompra->id;
    }

    private function prepareData($dato)
    {
        $data = array();
        $data['id'] = '';
        $data['sucursal_id'] = $dato['sucursal_id'];
        $data['proveedor_id'] = $dato['proveedor_id'];
        $data['nro_factura'] = $dato['nro_factura'];
        $data['total'] = $dato['total'];
        $data['user_id'] = \Auth::user()->id;
        return $data;
    }

    private function getRepoAsientoCompraDetalles()
    {
        return new RepoAsientoCompraDetalles();
    }

    public function findAndPaginate(array $datos)
    {
        $model = $this->getModel();

        if(isset($datos['proveedor_id']))
            $model = $model->where('proveedor_id',$datos['proveedor_id']);
        if(isset($datos['sucursal_id']))
            $model = $model->where('sucursal_id',$datos['sucursal_id']);
        if(isset($datos['fecha']))
            $model = $model->whereDate('created_at', '=', $datos['fecha']);

        $model = $model->with('sucursal','proveedor')->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }
}