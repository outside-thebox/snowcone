<?php

namespace App\Http\Controllers;

use App\Snowcone\Repositories\RepoUser;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $repoUser;

    public function __construct(RepoUser $repoUser)
    {
        $this->repoUser = $repoUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('users.index');
    }

    public function buscar(Request $request)
    {
        return $this->repoUser->findAndPaginate($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = null;
        $titulo = "Agregar";
        return View('users.formulario',compact('titulo','user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,$this->getRules($request->get('id')));
        $this->repoUser->createOrUpdateUser($request->toArray());

        return \Response()->json(['success' => true],200);
//        if($request->get('id'))
//        {
//            $this->repoUser->createOrUpdateUser($request->toArray());
//        }
//        else
//        {
//            $user = $this->repoUser->createUser($request->toArray());
//            $this->repoUsersXNegocio->getModel()->firstOrCreate(['user_creador_id' => $user->id,'negocio_id' => auth()->user()->usersxnegocio->negocio_id]);
//            $mail = new ShelterMailer();
//            $mail->sendMailWelcome($user);

//        }
//        return redirect(route('usersxnegocio'))->with('alert','Guardado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $titulo = "Editar";
        return View("users.formulario",compact('titulo','user_id'));
    }

    public function getDataUser(Request $request)
    {
        $user = $this->repoUser->find($request->get("user_id"));
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getRules($id)
    {
        if($id)
        {
            return [
                'nombre' => 'required|max:255',
                'apellido' => 'required|max:255',
                'tipo_usuario_id' => 'required',
                'dni' => 'required|max:255|unique:users,dni,'.$id.",id"
            ];
        }
        else
        {
            return [
                'nombre' => 'required|max:255',
                'apellido' => 'required|max:255',
                'tipo_usuario_id' => 'required',
                'dni' => 'required|max:255|unique:users,dni,'.$id.",id",
                'password' => 'required|min:6|confirmed'
            ];

        }
    }

    public function desactivar(Request $request)
    {
        $user = $this->repoUser->find($request->get('id'));
        $user->delete();
        return \Response()->json(['success' => true],200);
    }

    public function activar(Request $request)
    {
        $this->repoUser->activar($request->get('id'));
        return \Response()->json(['success' => true],200);
    }

    public function resetPassword(Request $request)
    {
        $this->repoUser->resetPassword($request->get('id'));
        return \Response()->json(['success' => true],200);
    }
}
