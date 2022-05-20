<?php

namespace App\Http\Middleware;

class Maintenance{

    /**
     * Metodo responsasvel por execultar o middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        if(getenv('MAINTENANCE') == 'true'){
            throw new \Exception("Pagina em Manutenção", 200);
        }
        return $next($request);
    }
}