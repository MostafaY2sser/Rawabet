<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if($guard == 'provider')
               return  redirect()->route('provider.dashboard');
             if($guard == 'customer')
               return  redirect()->route('customer.dashboard');
             if($guard == 'admin') {
               if ($this->isAdminTwoFactorEnabled() && !session('admin_2fa_verified', false)) {
                    return redirect()->route('admin.2fa.form');
               }

               return redirect()->route('admin.dashboard');
             }
            }
        }

        return $next($request);
    }

    protected function isAdminTwoFactorEnabled(): bool
    {
        if (!Schema::hasTable('settings')) {
            return false;
        }

        return (string) Setting::where('key', 'admin_2fa_enabled')->value('value') === '1';
    }
}
