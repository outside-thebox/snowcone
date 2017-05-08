<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoTiposUsuarios;

class TiposUsuariosController extends Controller
{
    private $repoTiposUsuarios;

    public function __construct(RepoTiposUsuarios $repoTiposUsuarios)
    {
        $this->repoTiposUsuarios = $repoTiposUsuarios;
    }

    public function all()
    {
        return $this->repoTiposUsuarios->all();
    }

    public function getTiposUsuariosWithoutAdmin()
    {
        return $this->repoTiposUsuarios->getTiposUsuariosWithoutAdmin();
    }
}
