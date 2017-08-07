<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 18:23
 */

namespace App\Http\Controllers;

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


        $this->repoPresupuesto->store($data['cliente'],$data['precio_total'],$lista);

        




    }


}