<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 29/07/17
 * Time: 00:21
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoArticulos;
use App\Snowcone\Repositories\RepoBoleta;
use App\Snowcone\Repositories\RepoStockXArticulos;
use Illuminate\Http\Request;
use Psy\Test\Exception\RuntimeExceptionTest;

class ArticulosXStockController extends Controller
{
    private $repoArticulos;
    private $repoStockXArticulos;
    private $repoBoleta;

    /**
     * ArticulosXStockController constructor.
     * @param RepoStockXArticulos $repoStockXArticulos
     * @param RepoBoleta $repoBoleta
     * @param RepoArticulos $repoArticulos
     */
    public function __construct(RepoStockXArticulos $repoStockXArticulos, RepoBoleta $repoBoleta, RepoArticulos $repoArticulos)
    {
        $this->repoStockXArticulos = $repoStockXArticulos;
        $this->repoBoleta = $repoBoleta;
        $this->repoArticulos = $repoArticulos;
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
        $this->repoStockXArticulos->update($request->all());
        return \Response()->json(['success' => true], 200);
    }
    public function addBoleta()
    {
        return view("articulos.add_boleta");
    }

    public function buscarxstockall(Request $request)
    {

        return $this->repoStockXArticulos->findAll($request->all());
    }
    public function datosinput(Request $request)
    {
        $cont =0;
//        dd($request->all());
        if(!$this->repoBoleta->validarboleta($request['proveedor_id'],$request['nro_factura'])) {
            foreach ($request['row'] as $key => $item) {
                if ($item['addstock'] > 0) {
                    $aux['id'] = $item['id'];
                    $aux['precio_compra'] = $item['precio_compra'];
                    $aux['stock'] = $item['stock'] + $item['addstock'];
                    $cont = 1;
                    $this->repoStockXArticulos->update($aux);

                }
            };
            if($cont == 1) {
                $this->altaboleta($request['row']);
                return \Response()->json(['success' => true], 200);
            }
            else
                return \Response()->json(['success' => false, 'descripcion' => 'No cargo ningun stock'], 404);

        }else {
            return \Response()->json(['success' => false, 'descripcion' => 'Nro factura y Proveedor ya existen'], 404);
        }
    }

    private function altaboleta($row)
    {
        foreach ($row as $key => $item) {

            if($item['addstock'] > 0){

                $aux['id'] = "";
                $aux['nro_factura'] = $item['nro_factura'];
                $aux['proveedor_id'] = $item['proveedor_id'];
                $aux['articulo_id'] = $item['id'];
                $aux['sucursal_id'] = ENV('APP_SUCURSAL',1);
                $aux['cantidad'] = $item['addstock'];
                $aux['precio_compra'] = $item['precio_compra'];
                $aux['user_id'] = \Auth::user()->id;

                $this->repoBoleta->createOrUpdate($aux);
            }
        };


    }

}