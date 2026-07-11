<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class AdminTwoFactorVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        if (!$this->isTwoFactorEnabled()) {
            return $next($request);
        }

        if (!$request->session()->get('admin_2fa_verified', false)) {
            return redirect()->route('admin.2fa.form')
                ->withErrors(['code' => 'يرجى إدخال رمز التحقق المرسل إلى بريدك الإلكتروني أولاً.']);
        }

        return $next($request);
    }

    protected function isTwoFactorEnabled(): bool
    {
        if (!Schema::hasTable('settings')) {
            return false;
        }

        return (string) Setting::where('key', 'admin_2fa_enabled')->value('value') === '1';
    }
}
