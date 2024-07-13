<?php

namespace App\Http\Middleware;

use App\Models\PermessionModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class redirectAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            $permission = PermessionModel::where('user_id', $user->id)->first();

            if ($permission && $permission->isAdmin == 1) {
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->route('dashboard')->with('error', "Access denied. You are not admin.");
    }
}
