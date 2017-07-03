<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 10:04
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoProveedores;
use App\Snowcone\Repositories\RepoUnidadesMedidas;

class ProveedoresController extends Controller
{
    private $repoProveedores;

    public function __construct(RepoProveedores $repoProveedores)
    {
        $this->repoProveedores = $repoProveedores;
    }

    public function all()
    {
        return $this->repoProveedores->all();
    }

}
