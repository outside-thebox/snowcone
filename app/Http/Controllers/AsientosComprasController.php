<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 14:32
 */

namespace App\Http\Controllers;
use App\Snowcone\Repositories\RepoAsientoCompra;
use App\Snowcone\Repositories\RepoProveedores;
use App\Snowcone\Repositories\RepoSucursales;
use App\Snowcone\Repositories\RepoAsientoCompraDetalles;
use Illuminate\Http\Request;

class AsientosComprasController extends Controller
{
    private $repoAsientoCompra;
    private $repoProveedores;
    private $repoSucursales;
    private $repoAsientoCompraDetalles;


    public function __construct( RepoAsientoCompra $repoAsientoCompra, RepoProveedores $repoProveedores, RepoSucursales $repoSucursales, RepoAsientoCompraDetalles $repoAsientoCompraDetalles)
    {
        $this->repoAsientoCompra = $repoAsientoCompra;
        $this->repoProveedores = $repoProveedores;
        $this->repoSucursales = $repoSucursales;
        $this->repoAsientoCompraDetalles = $repoAsientoCompraDetalles;
    }
    public function index()
    {
        return View("asiento_compras.index");
    }

    public function create()
    {
        return View("asiento_compras.add_asiento");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $id = $this->repoAsientoCompra->store($data);

        return \Response()->json(['success' => true,'id' => $id], 200);
    }

    public function buscar(Request $request)
    {
        return $this->repoAsientoCompra->findAndPaginate($request->all())->paginate(env('APP_CANT_PAGINATE',10));
    }

    public function exportarPDF(Request $request)
    {
        $data = $request->all();
        $asientos = $this->repoAsientoCompra->findAndPaginate($data)->get();

        if($data['proveedor_id']) {
            $proveedor = $this->repoProveedores->find($data['proveedor_id']);
            $proveedor = $proveedor->descripcion;
        }
        else
            $proveedor = 'Todos';
        if($data['sucursal_id']) {
            $sucursal  = $this->repoSucursales->find($data['sucursal_id']);
            $sucursal = $sucursal->nombre;
        }
        else
            $sucursal = 'Todos';

        $fecha =  ($data['fecha']) ? date('d-m-Y',strtotime($data['fecha'])) : '--';;

        $pdf = \PDF::loadView('asiento_compras.PDF', compact("asientos","sucursal","proveedor","fecha"));
        return $pdf->stream("AsientoCompras.pdf");

    }
    public function exportardetallePDF(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $asiento = $this->repoAsientoCompra->find($id);
        $asientosdetalle = $this->repoAsientoCompraDetalles->buscarxasiento($id);
        $pdf = \PDF::loadView('asiento_compras.detallePDF', compact("asientosdetalle","id",'asiento'));
        return $pdf->stream("Asientocomprasdetalle-".$id.".pdf");

    }
}