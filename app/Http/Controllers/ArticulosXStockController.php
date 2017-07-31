<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 29/07/17
 * Time: 00:21
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoStockXArticulos;
use Illuminate\Http\Request;

class ArticulosXStockController extends Controller
{
    private $repoArticulos;
    private $repoStockXArticulos;

    public function __construct(RepoStockXArticulos $repoStockXArticulos)
    {
        $this->repoStockXArticulos = $repoStockXArticulos;
    }

    public function prices()
    {
        return View("articulos.prices");
    }

    public function buscarxstock(Request $request)
    {
        $array_missing = $this->repoStockXArticulos->getRecordsMissing();
        $this->repoStockXArticulos->addRecords($array_missing);
        return $this->repoStockXArticulos->findAndPaginateStock($request->all());
    }

    public function updatePrices(Request $request)
    {
        $this->repoStockXArticulos->updatePrices($request);
        return \Response()->json(['success' => true],200);
    }
    public function updateBoleta(Request $request)
    {
        $this->repoStockXArticulos->updateBoleta($request);
        return \Response()->json(['success' => true],200);
    }
    public function addBoleta()
    {
        return view("articulos.add_boleta");
    }
}