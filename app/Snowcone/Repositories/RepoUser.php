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

    public function createUser($data)
    {
        $user = $this->getModel()->firstOrNew(['id' => $data['id']]);
        if($data['id'] == "")
        {
            $user->user_creador_id = auth()->user()->id;
            $data['password'] = bcrypt($data['password']);
        }
//        dd($user);

        $user->fill($data);
        $user->registration_token = str_random(20);
        $user->save();
        return $user;
    }*/

    public function activar($id)
    {
        $this->getModel()->withTrashed()->find($id)->update(['deleted_at' => null]);
    }

}