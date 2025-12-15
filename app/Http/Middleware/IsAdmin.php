<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user(); // usuario autenticado (por ejemplo con Sanctum)

        // Si no está logueado
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Si no es admin
        if (($user->role ?? 'cliente') !== 'admin') {
            return response()->json(['message' => 'No autorizado (solo admin)'], 403);
        }

        return $next($request);
    }
}