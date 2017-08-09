<?php
/**
 * Created by PhpStorm.
 * User: damián
 * Date: 06/08/2017
 * Time: 20:35
 */
namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\Presupuesto;

class RepoPresupuesto extends Repo
{

    function getModel()
    {
        return new Presupuesto();
    }

    public function createOrUpdate($data)
    {
        $presupuesto = $this->getModel()->firstOrNew(['id' => $data['id']]);

        $presupuesto->fill($data);
        $presupuesto->save();
        return $presupuesto;
    }

    private function prepareData($cliente, $precio_total)
    {
        $data = array();
        $data['id'] = '';
        $data['sucursal_id'] = env('APP_SUCURSAL',1);
        $data['cliente'] = $cliente;
        $data['precio_total'] = $precio_total;
        $data['user_id'] = \Auth::user()->id;

        return $data;
    }

    private function getRepoPresupuestoXArticulos()
    {
        return new RepoPresupuestoXArticulos();
    }

    private function getRepoStockXArticulos()
    {
        return new RepoStockXArticulos();
    }

    public function store($cliente, $precio_total, $lista)
    {
        $presupuesto = $this->createOrUpdate($this->prepareData($cliente,$precio_total));

        foreach($lista as $l)
        {
            $data = $this->getRepoPresupuestoXArticulos()->prepareData($presupuesto['id'],$l);
            $this->getRepoPresupuestoXArticulos()->createOrUpdate($data);

            $this->getRepoStockXArticulos()->updateStock($l->id,$l);
        }
    }

    public function buscar()
    {
        $model = $this->getModel();

        $model = $model->where('sucursal_id',env('APP_SUCURSAL',1));

        $model = $model->with('estado');

        $model = $model->orderBy('created_at', 'desc');

        return $model->get();


    }
}