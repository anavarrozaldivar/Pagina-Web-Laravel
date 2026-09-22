<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $role = $user->roleRelation;

        if (! $role) {
            abort(403);
        }

        /*
         * El administrador tiene acceso completo.
         */
        if ($role->name === 'admin') {
            return $next($request);
        }

        /*
         * Comprobar el permiso solicitado.
         */
        $hasPermission = $role->permissions()
            ->where('name', $permission)
            ->exists();

        if (! $hasPermission) {
            abort(403);
        }

        return $next($request);
    }
}
