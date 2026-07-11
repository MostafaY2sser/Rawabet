<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;



class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'offer_days' => 'required|integer|min:1',
            'admin_2fa_enabled' => 'nullable|boolean',
            'mail_mailer' => 'required|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
        ]);

        $settingKeys = [
            'tax_percentage',
            'offer_days',
            'admin_2fa_enabled',
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ];

        foreach ($settingKeys as $key) {
            $value = $key === 'admin_2fa_enabled'
                ? ($request->boolean('admin_2fa_enabled') ? '1' : '0')
                : $request->input($key);

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'تم حفظ الإعدادات');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'nullable|email',
        ]);

        $to = $request->input('test_email') ?: auth('admin')->user()?->email;
        if (!$to) {
            return redirect()->back()->withErrors(['test_email' => 'يرجى إدخال بريد إلكتروني صالح للإرسال التجريبي.']);
        }

        try {
            Mail::raw('هذه رسالة تجريبية من إعدادات البريد الإلكتروني في لوحة الإدارة.', function ($message) use ($to) {
                $message->to($to)->subject('اختبار إعدادات البريد الإلكتروني');
            });
        } catch (Throwable $e) {
            return redirect()->back()->withErrors(['test_email' => 'فشل إرسال البريد التجريبي. تحقق من إعدادات البريد ثم حاول مرة أخرى.']);
        }

        return redirect()->back()->with('success', 'تم إرسال البريد التجريبي بنجاح.');
    }
}