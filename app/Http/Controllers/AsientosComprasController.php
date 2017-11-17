<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 14:32
 */

namespace App\Http\Controllers;
use App\Snowcone\Repositories\RepoAsientoCompra;
use Illuminate\Http\Request;

class AsientosComprasController extends Controller
{
    private $repoAsientoCompra;


    public function __construct( RepoAsientoCompra $repoAsientoCompra)
    {
        $this->repoAsientoCompra = $repoAsientoCompra;
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
        return $this->repoAsientoCompra->findAndPaginate($request->all());
    }

}