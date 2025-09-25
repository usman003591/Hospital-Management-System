<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {

            if (auth()->user()->status==0) {

                $request->session()->invalidate();
                $request->session()->regenerateToken();          
        
                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect('/login');
            
            }

            $role_id = Auth::user()->role_id;
            $role = Role::find($role_id);
            if ($role) {
            Session::put('rights', $role->permissions());
            }

            return $next($request);
        }

        return ErrorMessage('login');
    }
}
