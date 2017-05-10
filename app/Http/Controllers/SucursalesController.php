<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoSucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{

    private $repoSucursales;

    public function __construct(RepoSucursales $repoSucursales)
    {
        $this->repoSucursales = $repoSucursales;
    }

    public function index()
    {
        $sucursales = $this->repoSucursales->all();
        return View('sucursales.index',compact('sucursales'));
    }

    public function create()
    {
        $sucursal_id = null;
        $titulo = "Agregar";
        return View('sucursales.formulario',compact('titulo','sucursal_id'));
    }

    public function store(Request $request)
    {
        //dd($request->toArray());
        $this->validate($request, $this->getRules($request->get('id')));
        $this->repoSucursales->createOrUpdate($request->toArray());

        return \Response()->json(['success' => true], 200);
    }
    public function show($id)
    {
       //
    }

    public function edit($id)
    {
        $sucursal = $this->repoSucursales->find($id);
        $titulo = "Editar";
        return View('sucursales.formulario',compact('titulo','sucursal'));
    }

    public function destroy($id)
    {
        //
    }

    protected function getRules($id)
    {
        if($id)
        {
            return [
                'nombre' => 'required|max:255',
                'direccion' => 'required|max:255',
                'telefono' => 'required'
            ];
        }
        else
        {
            return [
                'nombre' => 'required|max:255',
                'direccion' => 'required|max:255',
                'telefono' => 'required'
            ];

        }
    }

}
