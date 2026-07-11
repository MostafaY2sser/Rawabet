<?php

namespace App\Http\Middleware;

use App\Enums\CustomerStatus;
use App\Enums\ProviderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class ProviderAccountActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $provider = Auth::guard('provider')->user();

        if ($provider->status == ProviderStatus::REQUIREUPDATE->value)
            return redirect()->route('provider.compelete.account');
        elseif ($provider->status == ProviderStatus::PENDING->value){
            auth('provider')->logout();

        return redirect()->route('provider.login')->with('error', 'حسابك ما زال قيد المراجعة');
        }

        return $next($request);
    }
}
