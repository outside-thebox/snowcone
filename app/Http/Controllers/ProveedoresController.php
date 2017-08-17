<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 10:04
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoProveedores;
use App\Snowcone\Repositories\RepoUnidadesMedidas;

class ProveedoresController extends Controller
{
    private $repoProveedores;

    public function __construct(RepoProveedores $repoProveedores)
    {
        $this->repoProveedores = $repoProveedores;
    }

    public function all()
    {
        return $this->repoProveedores->all();
    }


    public function exportarPDF()
    {
        $proveedores = $this->repoProveedores->all();
        $pdf = \PDF::loadView('articulos.listado', compact("proveedores"));
        return $pdf->download("Listado de articulos.pdf");
    }

    public function exportarListadoClientesPDF()
    {
        $proveedores = $this->repoProveedores->all();
        $pdf = \PDF::loadView('articulos.listado_clientes', compact("proveedores"));
        return $pdf->download("Listado de articulos para clientes.pdf");
    }

    public function exportarConStockPDF()
    {
        $proveedores = $this->repoProveedores->all();
        $pdf = \PDF::loadView('articulos.listado_con_stock', compact("proveedores"));
        return $pdf->download("Listado de articulos con stock.pdf");
    }
}
