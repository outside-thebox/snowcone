<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 26/05/17
 * Time: 00:37
 */
namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\UnidadMedida;

class RepoUnidadesMedidas extends Repo {

    function getModel()
    {
        return new UnidadMedida();
    }

}