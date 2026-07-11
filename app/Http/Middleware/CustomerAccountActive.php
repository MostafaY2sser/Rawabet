<?php

namespace App\Http\Middleware;

use App\Enums\CustomerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class CustomerAccountActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->status == CustomerStatus::REQUIREUPDATE->value)
            return redirect()->route('customer.compelete.account');
        elseif ($customer->status == CustomerStatus::PENDING->value){
             auth('customer')->logout();

            return redirect()->route('customer.login')->with('error', 'حسابك ما زال قيد المراجعة');
        }
        return $next($request);
    }
}
