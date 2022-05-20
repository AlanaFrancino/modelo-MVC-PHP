<?php

namespace App\Http\Middleware;
use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout{

    /**
     * Metodo responsasvel por execultar o middleware
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        if(SessionAdminLogin::isLogged()){
            $request->getRouter()->redirect('/admin');
        }
        return $next($request);
    }
}