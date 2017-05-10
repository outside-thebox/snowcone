<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 05/05/17
 * Time: 10:58
 */

namespace App\Snowcone\Repositories;


use App\Snowcone\Entities\TipoUsuario;

class RepoTiposUsuarios extends Repo {

    function getModel()
    {
        return new TipoUsuario();
    }

    public function getTiposUsuariosWithoutAdmin()
    {
        return $this->getModel()->where('id','<>',1)->get(['id','descripcion']);
    }

    public function getTiposUsuariosWithAdmin()
    {
        return $this->getModel()->get(['id','descripcion']);
    }
}