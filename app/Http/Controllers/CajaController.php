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
use App\Snowcone\Repositories\RepoSucursales;
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

    public function cierres_caja_master()
    {
        return view("caja.cierres-cajas");
    }

    public function buscar()
    {
        return $this->repoCajaCerrada->cajasPorDia();
    }

    public function all(Request $request)
    {
        return $this->repoCajaCerrada->buscar($request->all());
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

    public function exportarPDF($id,$sucursal_id=null)
    {
        if($sucursal_id)
        {
            $repoSucursales = new RepoSucursales();
            $sucursal = $repoSucursales->find($sucursal_id);
//            dd($sucursal);
            $connection = $sucursal->conexion;
//            $sucursal = $this->getModelSucursal()->find(env('APP_SUCURSAL',1));
        }
        else
        {
            $connection = null;
            $sucursal = $this->getModelSucursal()->find(env('APP_SUCURSAL',1));
        }
        $caja = $this->repoCajaCerrada->find($id,$connection);
        $caja->total = $this->repoCajaCerrada->getTotal($caja->id,$connection);
        $caja->cantidad = $this->repoCajaCerrada->getCantidad($caja->id,$connection);



        $pdf = \PDF::loadView('caja.PDF', compact("caja","sucursal"));
        return $pdf->stream("Caja-".$caja->id.".pdf");

    }
}