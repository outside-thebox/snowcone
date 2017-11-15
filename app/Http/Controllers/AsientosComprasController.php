<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 15/11/2017
 * Time: 14:32
 */

namespace App\Http\Controllers;
use App\Snowcone\Repositories\RepoArticulos;

class AsientosComprasController extends Controller
{
    private $repoArticulos;


    public function __construct( RepoArticulos $repoArticulos)
    {
        $this->repoArticulos = $repoArticulos;

    }
    public function index()
    {
        return View("asiento_compras.add_asiento");
    }
}