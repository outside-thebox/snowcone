<?php
/**
 * User: damian
 * Date: 12/08/17
 * Time: 20:22
 */

namespace App\Snowcone\Repositories;

use App\Snowcone\Entities\CajaCerrada;

class RepoCajaCerrada extends Repo {

    function getModel()
    {
        return new CajaCerrada();
    }

    public function prepareData()
    {
        $data = [];
        $data['id'] = '';
        $data['sucursal_id'] = env('APP_SUCURSAL',1);
        $data['user_id'] = \Auth::user()->id;
        $data['fecha'] = date("Y-m-d");

        return $data;


    }

}