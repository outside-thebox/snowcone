<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/05/17
 * Time: 00:38
 */

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoUnidadesMedidas;

class UnidadesMedidaController extends Controller
{
    private $repoUnidadesMedidas;

    public function __construct(RepoUnidadesMedidas $repoUnidadesMedidas)
    {
        $this->repoUnidadesMedidas = $repoUnidadesMedidas;
    }

    public function all()
    {
        return $this->repoUnidadesMedidas->all();
    }

}
