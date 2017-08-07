<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    var $redirigir = [
        1 => 'users.index',
        2 => 'sucursales.index',
        3 => 'articulos.index',
        4 => 'presupuesto.index'
    ];


    public function redirect($id)
    {
        return redirect(route($this->redirigir[$id]))->with('alert','Guardado correctamente');
    }

}
