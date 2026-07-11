<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Throwable;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return view('customer.auth.login');
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
        
        
        
        if (auth('customer')->attempt($request->only('email', 'password'))) {
            return redirect()->route('customer.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة']);
    }
    public function logout()
    {
        // Logic for logging out the user
        auth('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function forgotPassword()
    {
        return view('customer.auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.exists' => 'لا يوجد حساب مرتبط بهذا البريد الإلكتروني.',
        ]);

        $remainingSeconds = $this->secondsUntilResendAllowed($request);
        if ($remainingSeconds > 0) {
            return back()->withErrors(['email' => "يرجى الانتظار {$remainingSeconds} ثانية قبل إعادة إرسال الرمز."]);
        }

        $code = (string) random_int(100000, 999999);
        DB::table('customer_password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        try {
            Mail::raw("رمز استعادة كلمة المرور هو: {$code}\nصلاحية الرمز 10 دقائق.", function ($message) use ($request) {
                $message->to($request->email)->subject('رمز استعادة كلمة المرور');
            });
        } catch (Throwable $e) {
            \Log::info($e->getMessage());
            return back()->withErrors(['email' => 'تعذر إرسال الرمز حالياً. حاول مرة أخرى لاحقاً.']);
        }

        session([
            'customer_reset_email' => $request->email,
            'customer_reset_verified' => false,
            'customer_reset_resend_available_at' => now()->addSeconds(30)->timestamp,
        ]);

        return redirect()->route('customer.password.verify.form')->with('success', 'تم إرسال رمز الاستعادة إلى بريدك الإلكتروني.');
    }

    public function showVerifyCodeForm()
    {
        if (!session('customer_reset_email')) {
            return redirect()->route('customer.password.forgot');
        }

        $remainingSeconds = max(0, (int) session('customer_reset_resend_available_at', 0) - now()->timestamp);
        return view('customer.auth.verify-reset-code', compact('remainingSeconds'));
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ], [
            'code.required' => 'رمز التحقق مطلوب.',
            'code.digits' => 'رمز التحقق يجب أن يتكون من 6 أرقام.',
        ]);

        $email = session('customer_reset_email');
        if (!$email) {
            return redirect()->route('customer.password.forgot');
        }

        $record = DB::table('customer_password_reset_codes')->where('email', $email)->first();
        if (!$record || now()->greaterThan($record->expires_at)) {
            return back()->withErrors(['code' => 'انتهت صلاحية الرمز. يرجى طلب رمز جديد.']);
        }

        if (!Hash::check($request->code, $record->code)) {
            return back()->withErrors(['code' => 'رمز التحقق غير صحيح.']);
        }

        session(['customer_reset_verified' => true]);

        return redirect()->route('customer.password.reset.form')->with('success', 'تم التحقق من الرمز. يمكنك الآن تعيين كلمة مرور جديدة.');
    }

    public function showResetPasswordForm()
    {
        if (!session('customer_reset_email') || !session('customer_reset_verified')) {
            return redirect()->route('customer.password.forgot');
        }

        return view('customer.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('customer_reset_email') || !session('customer_reset_verified')) {
            return redirect()->route('customer.password.forgot');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق.',
        ]);

        $email = session('customer_reset_email');
        $customer = Customer::where('email', $email)->firstOrFail();
        $customer->password = $request->password;
        $customer->save();

        DB::table('customer_password_reset_codes')->where('email', $email)->delete();
        session()->forget(['customer_reset_email', 'customer_reset_verified']);

        return redirect()->route('customer.login')->with('success', 'تم تغيير كلمة المرور بنجاح. يمكنك تسجيل الدخول الآن.');
    }

    public function resendResetCode(Request $request)
    {
        $email = session('customer_reset_email');
        if (!$email) {
            return redirect()->route('customer.password.forgot');
        }

        $remainingSeconds = $this->secondsUntilResendAllowed($request);
        if ($remainingSeconds > 0) {
            return back()->withErrors(['code' => "يرجى الانتظار {$remainingSeconds} ثانية قبل إعادة إرسال الرمز."]);
        }

        $code = (string) random_int(100000, 999999);
        DB::table('customer_password_reset_codes')->updateOrInsert(
            ['email' => $email],
            [
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(10),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        try {
            Mail::raw("رمز استعادة كلمة المرور هو: {$code}\nصلاحية الرمز 10 دقائق.", function ($message) use ($email) {
                $message->to($email)->subject('رمز استعادة كلمة المرور');
            });
        } catch (Throwable $e) {
            return back()->withErrors(['code' => 'تعذر إعادة إرسال الرمز حالياً. حاول مرة أخرى لاحقاً.']);
        }

        session(['customer_reset_resend_available_at' => now()->addSeconds(30)->timestamp]);

        return back()->with('success', 'تم إعادة إرسال رمز الاستعادة.');
    }

    protected function secondsUntilResendAllowed(Request $request): int
    {
        $availableAt = (int) $request->session()->get('customer_reset_resend_available_at', 0);
        return max(0, $availableAt - now()->timestamp);
    }
}
