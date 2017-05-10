<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 05/05/17
 * Time: 09:53
 */
namespace App\Snowcone\Repositories;


use App\User;

class RepoUser extends Repo {



    function getModel()
    {
        return new User();
    }

    /*public function update($id,$data)
    {
        $user = $this->getModel()->find($id);
        if(isset($data['foto']))
            $data['path_foto'] = $this->guardarArchivo("foto_perfil",$data['foto'],$id);

        $user->fill($data);
        $user->save();
    }

    */

    public function activar($id)
    {
        $this->getModel()->withTrashed()->find($id)->update(['deleted_at' => null]);
    }

    public function createOrUpdateUser($data)
    {
        $user = $this->getModel()->firstOrNew(['id' => $data['id']]);
//        dd($user);
        if($data['id'] == "")
        {
            $data['password'] = bcrypt($data['password']);
            $user->fill($data);
        }
        else
        {
            $password = $user->password;
            $user->fill($data);
            $user->password = $password;
        }
//        dd($user);

        $user->save();
        return $user;
    }

    public function findAndPaginate(array $datos)
    {
        $model = $this->getModel();

        if(isset($datos['nombre']))
            $model = $model->where('nombre','like','%'.$datos['nombre'].'%');
        if(isset($datos['apellido']))
            $model = $model->where('apellido','like','%'.$datos['apellido'].'%');
        if(isset($datos['dni']))
            $model = $model->where('dni','like','%'.$datos['dni'].'%');

        $model = $model->withTrashed()->paginate(env('APP_CANT_PAGINATE',10));

        return $model;

    }

    public function resetPassword($id)
    {
        $this->getModel()->withTrashed()->find($id)->update(['password' => bcrypt(123456)]);
    }

}