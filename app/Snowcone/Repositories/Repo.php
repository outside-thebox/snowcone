<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 05/05/17
 * Time: 09:54
 */
namespace App\Snowcone\Repositories;

abstract class Repo {

    abstract function getModel();

    public function find($id)
    {
        return $this->getModel()->withTrashed()->find($id);
    }

    public function all()
    {
        return $this->getModel()->all();
    }

   public function guardarArchivo($carpeta,$archivo,$id)
    {
        if ($archivo)
        {
            $array = explode('.',$archivo->getClientOriginalName());
            $extension = end($array);

            $random_name = str_random(20).".".$extension;
            $archivo->move("$carpeta/",$id."-".$random_name);
            $path = "$carpeta/".$id."-".$random_name;
            return $path;
        }
    }



}