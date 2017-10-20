<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 4/7/2017
 * Time: 12:38
 */

namespace App\Http\Controllers;


use App\Snowcone\Entities\Sucursales;
use App\Snowcone\Repositories\RepoCajaCerrada;
use App\Snowcone\Repositories\RepoPresupuesto;
use Illuminate\Http\Request;

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

    public function history()
    {
        return view("caja.history");
    }

    public function buscar()
    {
        return $this->repoCajaCerrada->cajasPorDia();
    }

    public function cerrarCaja()
    {
        $data = $this->repoCajaCerrada->prepareData();
        $entity = $this->repoCajaCerrada->createOrUpdate($data);

        $this->repoPresupuesto->updateCerrarCaja($entity->id);
        return \Response()->json(['success' => true], 200);
    }

    private function getModelSucursal()
    {
        return new Sucursales();
    }

    public function exportarPDF($id)
    {
        $caja = $this->repoCajaCerrada->find($id);
        $caja->total = $this->repoCajaCerrada->getTotal($caja->id);
        $caja->cantidad = $this->repoCajaCerrada->getCantidad($caja->id);

        $sucursal = $this->getModelSucursal()->find(env('APP_SUCURSAL',1));


        $pdf = \PDF::loadView('caja.PDF', compact("caja","sucursal"));
        return $pdf->download("Caja-".$caja->id.".pdf");

    }
}