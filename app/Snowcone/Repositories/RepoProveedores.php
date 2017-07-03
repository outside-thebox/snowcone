<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 03/07/17
 * Time: 10:05
 */

namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\Proveedor;

class RepoProveedores extends Repo {

    function getModel()
    {
        return new Proveedor();
    }

}