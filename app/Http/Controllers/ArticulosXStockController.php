<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 29/07/17
 * Time: 00:21
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoAjusteStock;
use App\Snowcone\Repositories\RepoArticulos;
use App\Snowcone\Repositories\RepoBoleta;
use App\Snowcone\Repositories\RepoPresupuestoXArticulos;
use App\Snowcone\Repositories\RepoStockXArticulos;
use Illuminate\Http\Request;
use Psy\Test\Exception\RuntimeExceptionTest;

class ArticulosXStockController extends Controller
{
    private $repoArticulos;
    private $repoStockXArticulos;
    private $repoBoleta;
    private $repoPresupuestoXArticulos;
    private $repoAjusteStock;

    public function __construct(RepoStockXArticulos $repoStockXArticulos, RepoBoleta $repoBoleta, RepoArticulos $repoArticulos,RepoPresupuestoXArticulos $repoPresupuestoXArticulos, RepoAjusteStock $repoAjusteStock)
    {
        $this->repoStockXArticulos = $repoStockXArticulos;
        $this->repoBoleta = $repoBoleta;
        $this->repoArticulos = $repoArticulos;
        $this->repoPresupuestoXArticulos = $repoPresupuestoXArticulos;
        $this->repoAjusteStock = $repoAjusteStock;
    }

    public function prices()
    {
        return View("articulos.prices");
    }

    public function buscarxstock(Request $request)
    {
        $array_missing = $this->repoStockXArticulos->getRecordsMissing();
        $this->repoStockXArticulos->addRecords($array_missing);
        $stockxarticulos = $this->repoStockXArticulos->findAndPaginateStock($request->all());

        $presupuestosSinCobrar = $this->repoPresupuestoXArticulos->buscarPresupuestosSinCobrar();

        foreach($presupuestosSinCobrar as $presupuestoSinCobrar)
        {
            foreach($stockxarticulos as $stockxarticulo)
            {
                if($presupuestoSinCobrar->articulo_id == $stockxarticulo->articulo_id)
                {
                    $stockxarticulo->stock = $stockxarticulo->stock - $presupuestoSinCobrar->cantidad;
//                    break;
                }
            }
        }


        return $stockxarticulos;


    }
    public function buscarxstockPrices(Request $request)
    {
        $array_missing = $this->repoStockXArticulos->getRecordsMissing();
        $this->repoStockXArticulos->addRecords($array_missing);
        return $this->repoStockXArticulos->findAll($request->all());
    }
    public function updatePrices(Request $request)
    {
        $this->repoStockXArticulos->update($request->all());
        return \Response()->json(['success' => true], 200);
    }

    public function updatetodoPrices(Request $request)
    {
        foreach ($request['row'] as $key => $item) {

            $this->repoStockXArticulos->update($item);
        };

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
        $cont=0;
        if(!$this->repoBoleta->validarboleta($request['proveedor_id'],$request['nro_factura'])) {
            foreach ($request['row'] as $key => $item) {
                if ($item['addstock'] > 0) {
//                    dd($item);
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

    public function control($articulo_id)
    {
        $articulo = $this->repoArticulos->find($articulo_id);

        $boletas = $this->repoBoleta->buscarboletaXArticulo($articulo_id);

        $presupuestos = $this->repoPresupuestoXArticulos->buscarPresuestoXArticulo($articulo_id);

        $stock_actual = $this->repoStockXArticulos->getStockActual($articulo_id);

//        dd($stock_actual);

        return view("articulos.control",compact('articulo',"boletas","presupuestos","stock_actual"));
    }

    /*
    function burbuja($A,$n)
    {
        for($i=1;$i<$n;$i++)
        {
            for($j=0;$j<$n-$i;$j++)
            {
                if($A[$j]['created_at']>$A[$j+1]['created_at'])
                {$k=$A[$j+1]; $A[$j+1]=$A[$j]; $A[$j]=$k;}
            }
        }

        return $A;
    }

    function main()
    {

        $VectorA=array(5,4,3,2,1);

        $VectorB=burbuja($VectorA,sizeof($VectorA));

        for($i=0;$i<sizeof($VectorB);$i++)
            echo $VectorB[$i]."\n";

    }*/

    public function update(Request $request)
    {
        $data = json_decode($request->get('data'))[0];

        $this->repoStockXArticulos->updateStockRemoto($data);

        $data = (array)$data;
        $data['id'] = '';
        $data['user_id'] = \Auth::user()->id;

        $this->repoAjusteStock->createOrUpdate($data);

        $this->repoAjusteStock->createOrUpdate($data,$data['conexion']);


    }



    public function traspasoMercaderia()
    {
        return view("traspaso_mercaderia.formulario");
    }



}