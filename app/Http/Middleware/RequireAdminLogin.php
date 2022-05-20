<?php

namespace App\Http\Middleware;
use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogin{

    /**
     * Metodo responsasvel por execultar o middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        if(!SessionAdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin/login');
        }
        return $next($request);
    }
}