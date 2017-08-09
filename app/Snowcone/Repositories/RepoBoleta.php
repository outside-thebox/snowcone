<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 8/8/2017
 * Time: 12:09
 */

namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\Boleta;

class RepoBoleta  extends Repo{

    function getModel()
    {
        // TODO: Implement getModel() method.
        return new Boleta();
    }
}