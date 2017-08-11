<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TiposUsuarios
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rol)
    {
        $user = Auth::user();
        $roles = explode("|", $rol);

        if(in_array($user->tipo_usuario_id,$roles)){
            return $next($request);
        }
        else{
            return redirect()->route('home');
        }

    }
}

