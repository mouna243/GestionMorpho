<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Departement
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next ,$departement): Response
    {
        if($request->user()->departement->name !== $departement) {
            return response()->json([
                'message' => 'Unauthorized',
                'seccess' => false
            ],401);
        }
        return $next($request);
    }
}
