<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 16/11/2017
 * Time: 18:53
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoAsientoCompraDetalles;
use Illuminate\Http\Request;

class AsientoCompraDetallesController extends Controller
{
    private $repoAsientoCompraDetalle;

    public function __construct( RepoAsientoCompraDetalles $repoAsientoCompraDetalles)
    {
        $this->repoAsientoCompraDetalle = $repoAsientoCompraDetalles;
    }

    public function buscar(Request $request)
    {
        $data = $request->all();
        return $this->repoAsientoCompraDetalle->buscarxasiento($data);
    }

}