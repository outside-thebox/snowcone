<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 4/7/2017
 * Time: 12:38
 */

namespace App\Http\Controllers;


use App\Snowcone\Repositories\RepoCajaCerrada;
use App\Snowcone\Repositories\RepoPresupuesto;

class CajaController
{
    private $repoCajaCerrada;
    private $repoPresupuesto;

    public function __construct(RepoCajaCerrada $repoCajaCerrada, RepoPresupuesto $repoPresupuesto)
    {
        $this->repoCajaCerrada = $repoCajaCerrada;
        $this->repoPresupuesto = $repoPresupuesto;
    }

    public function index()
    {
        return view("caja.index");
    }

    public function cerrarCaja()
    {
        $data = $this->repoCajaCerrada->prepareData();
        $entity = $this->repoCajaCerrada->createOrUpdate($data);

        $this->repoPresupuesto->updateCerrarCaja($entity->id);


        return \Response()->json(['success' => true], 200);


    }
}