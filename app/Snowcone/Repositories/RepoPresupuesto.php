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
        $data['precio_total'] = floatval(str_replace(",",".",$precio_total));
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

//        dd($presupuesto);
        foreach($lista as $l)
        {
            $data = $this->getRepoPresupuestoXArticulos()->prepareData($presupuesto['id'],$l);
            $this->getRepoPresupuestoXArticulos()->createOrUpdate($data);

            $this->getRepoStockXArticulos()->updateStock($l->id,$l);
        }

        return $presupuesto->id;
    }

    public function buscar($data=[])
    {
        $model = $this->getModel();

        $model = $model->where('sucursal_id',env('APP_SUCURSAL',1));

        $model = $model->with('estado','presupuestoxarticulo','presupuestoxarticulo.articulo');

        if(isset($data['id']))
        {
            if($data['id'] != '')
                $model->where('id',$data['id']);
        }

        $model = $model->where('caja_cerrada',0);


        $model = $model->orderBy('created_at', 'desc');

        return $model->get();


    }

    public function updateEstado($id, $estado_id)
    {
        $presupuesto = $this->createOrUpdate(['id' => $id]);
        $presupuesto->estado_id = $estado_id;

        $presupuesto->save();

    }

    private function presupuestosSinCancelar()
    {
        return $this->getModel()
            ->where("estado_id",1)
            ->where('sucursal_id',env('APP_SUCURSAL',1))
            ->get();
    }

    public function updateCerrarCaja($id)
    {
        $this->getModel()->where('caja_cerrada',0)->update(['caja_cerrada' => $id]);


        $presupuestos_sin_cancelar = $this->presupuestosSinCancelar();

//        dd($presupuestos_sin_cancelar);
        foreach($presupuestos_sin_cancelar as $presupuesto_sin_cancelar)
        {
            $presupuesto = $this->find($presupuesto_sin_cancelar->id);
            $presupuestoxarticulos = $this->getRepoPresupuestoXArticulos()->presupuestoxarticulos($presupuesto->id);
            foreach($presupuestoxarticulos as $presupuestoxarticulo)
            {
                $this->getRepoStockXArticulos()->updateStockCancelPresupuesto($presupuestoxarticulo->articulo_id,$presupuestoxarticulo->cantidad);
            }
            $this->updateEstado($presupuesto_sin_cancelar->id,3);
        }

    }

    public function isPossible($presupuesto_id,$estado_id)
    {
        $resultado = $this->getModel()->where('id',$presupuesto_id)->where('estado_id',$estado_id)->first();

        if($resultado)
            return true;


        return false;
    }

}