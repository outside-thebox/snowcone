<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoArticulos;
use Illuminate\Http\Request;

class ArticulosController extends Controller
{
    private $repoArticulos;

    public function __construct(RepoArticulos $repoArticulos)
    {
        $this->repoArticulos = $repoArticulos;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View("articulos.index");
    }

    public function buscar(Request $request)
    {
        return $this->repoArticulos->findAndPaginate($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articulo_id = null;
        $titulo = "Agregar";
        return View("articulos.formulario",compact('titulo','articulo_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getRules($request->get('id')),$this->getMessages());

        $data = $this->repoArticulos->prepareData($request->toArray());
        $this->repoArticulos->createOrUpdate($data);

        return \Response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($articulo_id)
    {
        $titulo = "Editar";
        return View("articulos.formulario",compact('titulo','articulo_id'));
    }

    public function getDataArticulo(Request $request)
    {
        return $this->repoArticulos->find($request->get("articulo_id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function eliminar(Request $request)
    {
        $user = $this->repoArticulos->find($request->get('id'));
        $user->delete();
        return \Response()->json(['success' => true],200);

    }

    private function getRules($id)
    {
        return [
            'cod' => 'required|numeric|unique:articulos,cod,'.$id.',id',
            'descripcion' => 'required|max:255',
            'precio_sugerido' => 'required',
            'precio_compra' => 'required',
            'unidad_medida_id' => 'required',
            'proveedor_id' => 'required'
        ];
    }

    private function getMessages()
    {
        return [
            'proveedor_id.required' => 'Debe seleccionar un proveedor',
            'unidad_medida_id.required' => 'Debe seleccionar una unidad de medida'
        ];
    }
}
