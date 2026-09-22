<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $role = $user->roleRelation;

        if (! $role || $role->name !== 'admin') {
            abort(403);
        }

        return $next($request);
    }
}
