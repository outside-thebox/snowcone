<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoBoleta;
use Illuminate\Http\Request;

class BoletasController extends Controller
{
    private $repoBoleta;

    public function __construct(RepoBoleta $repoBoleta)
    {
        $this->repoBoleta = $repoBoleta;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View("boleta.index");
    }
    public function buscarAgrupadoBoleta()
    {
        return $this->repoBoleta->buscarAgrupadoBoleta();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportarPDF()
    {

        $id = $_GET['nro_factura'];
        $boleta = $this->repoBoleta->buscarboleta($_GET);
        $pdf = \PDF::loadView('boleta.PDF', compact("boleta","id"));
        return $pdf->download("Boleta-".$id.".pdf");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->toArray());
        $this->validate($request, $this->getRules($request->get('id')));
        $this->repoBoleta->createOrUpdate($request->toArray());

        return \Response()->json(['success' => true], 200);
    }


}
