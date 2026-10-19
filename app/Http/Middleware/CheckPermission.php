<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Comprueba que el usuario esté autenticado y tenga el permiso solicitado.
     *
     * Uso: ->middleware('permiso:productos.crear')
     */
    public function handle(
        Request $request,
        Closure $next,
        string $permiso
    ): Response {
        $usuario = $request->user();

        if ($usuario === null) {
            // Las peticiones API reciben 401; las páginas web redirigen al login.
            if ($request->expectsJson()) {
                abort(401, 'Debes iniciar sesión.');
            }

            return redirect()->guest(route('login'));
        }

        if (!method_exists($usuario, 'tienePermiso')) {
            abort(
                403,
                'El usuario autenticado no tiene configurado el sistema de permisos.'
            );
        }

        if (!$usuario->tienePermiso($permiso)) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        return $next($request);
    }
}
