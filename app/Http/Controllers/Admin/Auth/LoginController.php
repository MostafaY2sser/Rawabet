<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
        ]);
        
        
        
        if (auth('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (!$this->isTwoFactorEnabled()) {
                $request->session()->put('admin_2fa_verified', true);
                return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
            }

            $request->session()->put('admin_2fa_verified', false);
            if (!$this->sendTwoFactorCode($request)) {
                auth('admin')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'لا يمكن إرسال رمز التحقق حالياً. تحقق من إعدادات البريد الإلكتروني.']);
            }

            return redirect()->route('admin.2fa.form')->with('success', 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.');
        }

        return back()->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة']);
    }

    public function showTwoFactorForm(Request $request)
    {
        if (!$this->isTwoFactorEnabled()) {
            return redirect()->route('admin.dashboard');
        }

        if ($request->session()->get('admin_2fa_verified', false)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.two-factor');
    }

    public function verifyTwoFactor(Request $request)
    {
        if (!$this->isTwoFactorEnabled()) {
            return redirect()->route('admin.dashboard');
        }

        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'رمز التحقق مطلوب.',
            'code.digits' => 'رمز التحقق يجب أن يتكون من 6 أرقام.',
        ]);

        $expectedCode = (string) $request->session()->get('admin_2fa_code');
        $expiresAt = (int) $request->session()->get('admin_2fa_expires_at', 0);

        if (empty($expectedCode) || $expiresAt < now()->timestamp) {
            return back()->withErrors(['code' => 'انتهت صلاحية رمز التحقق. يرجى طلب رمز جديد.']);
        }

        if ($request->code !== $expectedCode) {
            return back()->withErrors(['code' => 'رمز التحقق غير صحيح.']);
        }

        $request->session()->forget(['admin_2fa_code', 'admin_2fa_expires_at']);
        $request->session()->put('admin_2fa_verified', true);

        return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
    }

    public function resendTwoFactor(Request $request)
    {
        if (!$this->isTwoFactorEnabled()) {
            return redirect()->route('admin.dashboard');
        }

        if (!$this->sendTwoFactorCode($request)) {
            return back()->withErrors(['code' => 'فشل إرسال الرمز. تحقق من إعدادات البريد الإلكتروني.']);
        }

        return back()->with('success', 'تم إعادة إرسال رمز التحقق إلى بريدك الإلكتروني.');
    }

    public function logout()
    {
        request()->session()->forget(['admin_2fa_verified', 'admin_2fa_code', 'admin_2fa_expires_at']);
        auth('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    protected function isTwoFactorEnabled(): bool
    {
        if (!Schema::hasTable('settings')) {
            return false;
        }

        return (string) Setting::where('key', 'admin_2fa_enabled')->value('value') === '1';
    }

    protected function sendTwoFactorCode(Request $request): bool
    {
        $admin = auth('admin')->user();
        if (!$admin || !$admin->email) {
            return false;
        }

        $code = (string) random_int(100000, 999999);
        $request->session()->put('admin_2fa_code', $code);
        $request->session()->put('admin_2fa_expires_at', now()->addMinutes(10)->timestamp);

        try {
            Mail::raw("رمز التحقق الخاص بتسجيل دخول لوحة الإدارة هو: {$code} \nصلاحية الرمز 10 دقائق.", function ($message) use ($admin) {
                $message->to($admin->email)->subject('رمز تحقق تسجيل الدخول');
            });
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }
}
