<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 18:23
 */

namespace App\Http\Controllers;

use App\Snowcone\Entities\Presupuesto;
use App\Snowcone\Repositories\RepoArticulos;
use App\Snowcone\Repositories\RepoPresupuesto;
use App\Snowcone\Repositories\RepoPresupuestoXArticulos;
use App\Snowcone\Repositories\RepoStockXArticulos;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    private $repoStockXArticulos;
    private $repoPresupuesto;
    private $repoPresupuestoXArticulos;

    public function __construct(RepoPresupuesto $repoPresupuesto, RepoPresupuestoXArticulos $repoPresupuestoXArticulos, RepoStockXArticulos $repoStockXArticulos)
    {
        $this->repoStockXArticulos = $repoStockXArticulos;
        $this->repoPresupuesto = $repoPresupuesto;
        $this->repoPresupuestoXArticulos = $repoPresupuestoXArticulos;
    }

    public function index()
    {
        return view("presupuesto.index");
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $lista = json_decode($data['lista']);

        if(is_object($model = $this->repoStockXArticulos->validateStock($lista)))
            return \Response()->json(['success' => false,'id' => $model->id,'descripcion' => $model->descripcion],404);


        $id = $this->repoPresupuesto->store($data['cliente'],$data['precio_total'],$lista);

        return \Response()->json(['success' => true,'id' => $id], 200);
    }

    public function updateEstado(Request $request)
    {
        $this->repoPresupuesto->updateEstado($request['id'],$request['estado_id']);

        return \Response()->json(['success' => true], 200);

    }

    public function buscar(Request $request)
    {
//        dd($this->repoPresupuesto->buscar($request)[0]->created_at);
        return $this->repoPresupuesto->buscar($request);
    }

    public function exportarPDF($id)
    {
        $presupuesto = $this->repoPresupuesto->find($id);

//        dd($presupuesto->user);
        $pdf = \PDF::loadView('presupuesto.PDF', compact("presupuesto"));
        return $pdf->stream("Presupuesto-".$presupuesto->id.".pdf");

    }

    public function cancelar(Request $request)
    {
        if($this->repoPresupuesto->isPossible($request->get('id'),1))
        {
            $this->devolverStock($request);
            $this->repoPresupuesto->updateEstado($request->get('id'),3);

        }

    }

    private function devolverStock($request)
    {
        $id = $request->get('id');

        $presupuesto = $this->repoPresupuesto->find($id);

        $presupuestoxarticulos = $this->repoPresupuestoXArticulos->presupuestoxarticulos($presupuesto->id);

        foreach($presupuestoxarticulos as $presupuestoxarticulo)
        {
            $this->repoStockXArticulos->updateStockCancelPresupuesto($presupuestoxarticulo->articulo_id,$presupuestoxarticulo->cantidad);
        }

    }

    public function anular(Request $request)
    {
        if($this->repoPresupuesto->isPossible($request->get('id'),2))
        {
            $this->devolverStock($request);
            $this->repoPresupuesto->updateEstado($request->get('id'), 4);
        }
    }

}