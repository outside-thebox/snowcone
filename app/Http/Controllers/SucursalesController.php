<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoSucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SucursalesController extends Controller
{

    private $repoSucursales;

    public function __construct(RepoSucursales $repoSucursales)
    {
        $this->repoSucursales = $repoSucursales;
    }

    public function index()
    {
        $sucursales = $this->all();
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

    public function edit($sucursal_id)
    {
        //$sucursal = $this->repoSucursales->find($id);
        $titulo = "Editar";
        return View('sucursales.formulario',compact('titulo','sucursal_id'));
    }

    public function destroy($id)
    {
        //
    }
    public function getData()
    {
        $sucursal = $this->repoSucursales->find(Input::get("sucursal_id"));
        return $sucursal;
    }

    public function all()
    {
        return $this->repoSucursales->all();

    }

    public function buscar()
    {
        return $this->repoSucursales->findAndPaginate(Input::all());
    }
    public function desactivar(Request $request)
    {
        $sucursal = $this->repoSucursales->find($request->get('id'));
        $sucursal->delete();
        return \Response()->json(['success' => true],200);
    }

    public function activar(Request $request)
    {
        $this->repoSucursales->activar($request->get('id'));
        return \Response()->json(['success' => true],200);
    }

    protected function getRules($id)
    {
        if($id)
        {
            return [
                'nombre' => 'required|max:255',
                'direccion' => 'required|max:255',
                'telefono' => 'required',
                'email' => 'email|nullable'
            ];
        }
        else
        {
            return [
                'nombre' => 'required|max:255',
                'direccion' => 'required|max:255',
                'telefono' => 'required',
                'email' => 'email|nullable'
            ];

        }
    }

}
