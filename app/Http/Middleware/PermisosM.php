<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class PermisosM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controller = app('App\Http\Controllers\SeguridadController')->BuscarPermiso($request);
        $respuesta = $controller;
        if (!$respuesta) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthenticated.', 'permiso' => Route::current()->uri()], 401)->send();
            } else {
                return abort('401')->send();
            }
        } else {
            return $next($request);
        }
    }
}
