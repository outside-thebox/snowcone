<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 18:23
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoArticulos;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view("presupuesto.index");
    }


}