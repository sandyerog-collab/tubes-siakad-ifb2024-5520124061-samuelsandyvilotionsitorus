<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        if (!$request->user()) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array($request->user()->role, $roles, true)) {
            abort(
                403,
                'Anda tidak mempunyai izin untuk membuka halaman ini.'
            );
        }

        return $next($request);
    }
}