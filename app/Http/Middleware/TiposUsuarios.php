<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TiposUsuarios
{
    protected $tiposusuarios = [
        '1' => 'admin',
        '2' => 'gerente',
        '3' => 'encargado',
        '4' => 'ventas',
        '5' => 'caja'
    ];
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

        if( $rol >= $user->tipo_usuario_id ){
            return $next($request);
        }

        return redirect()->route('home');

    }
}
