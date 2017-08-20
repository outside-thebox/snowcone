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
        4 => 'presupuesto.index',
        5 => 'caja.index',
        6 => 'presupuesto.index',
        7 => 'caja.index'
    ];


    public function redirect($id)
    {
        if($id == 4)
            return redirect(route($this->redirigir[$id]))->with('alert','Enviado a caja');
        else if($id == 6 || $id == 7)
            return redirect(route($this->redirigir[$id]))->with('alert','Cancelado correctamente');
        else
            return redirect(route($this->redirigir[$id]))->with('alert','Guardado correctamente');

    }

}
