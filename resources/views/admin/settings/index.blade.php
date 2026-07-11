@extends('admin.layouts.main')

@section('content')

<div class="notifications" id="main_page">

    <h2>الإعدادات</h2>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="card p-3 mb-3">

            <div class="mb-3">
                <label>نسبة الضريبة (%)</label>
                <input type="number"
                       name="tax_percentage"
                       class="form-control"
                       value="{{ $settings['tax_percentage'] ?? 0 }}"
                       min="0"
                       max="100">
            </div>

            <div class="mb-3">
                <label>مدة ظهور العرض (بالأيام)</label>
                <input type="number"
                       name="offer_days"
                       class="form-control"
                       value="{{ $settings['offer_days'] ?? 7 }}"
                       min="1">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="admin2faEnabled" name="admin_2fa_enabled" value="1"
                    @checked(($settings['admin_2fa_enabled'] ?? '0') === '1')>
                <label class="form-check-label" for="admin2faEnabled">تفعيل التحقق بخطوتين لتسجيل دخول الأدمن</label>
            </div>

            <hr>
            <h5 class="mb-3">إعدادات البريد الإلكتروني</h5>

            <div class="mb-3">
                <label>Mailer</label>
                <input type="text" name="mail_mailer" class="form-control"
                       value="{{ $settings['mail_mailer'] ?? 'smtp' }}">
            </div>

            <div class="mb-3">
                <label>Host</label>
                <input type="text" name="mail_host" class="form-control"
                       value="{{ $settings['mail_host'] ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Port</label>
                <input type="number" name="mail_port" class="form-control"
                       value="{{ $settings['mail_port'] ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="mail_username" class="form-control"
                       value="{{ $settings['mail_username'] ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="text" name="mail_password" class="form-control"
                       value="{{ $settings['mail_password'] ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Encryption</label>
                <input type="text" name="mail_encryption" class="form-control"
                       value="{{ $settings['mail_encryption'] ?? 'tls' }}">
            </div>

            <div class="mb-3">
                <label>From Address</label>
                <input type="email" name="mail_from_address" class="form-control"
                       value="{{ $settings['mail_from_address'] ?? '' }}">
            </div>

            <div class="mb-3">
                <label>From Name</label>
                <input type="text" name="mail_from_name" class="form-control"
                       value="{{ $settings['mail_from_name'] ?? '' }}">
            </div>

            <button class="main_btn_bg">
                حفظ الإعدادات
            </button>

        </div>

    </form>

    <form action="{{ route('admin.settings.test.email') }}" method="POST">
        @csrf
        <div class="card p-3">
            <h5 class="mb-3">اختبار الإرسال</h5>
            <div class="mb-3">
                <label>بريد الاختبار (اختياري)</label>
                <input type="email" name="test_email" class="form-control" placeholder="اتركه فارغًا للإرسال إلى بريد حساب الأدمن الحالي">
            </div>
            <button class="main_btn_bg" type="submit">إرسال بريد تجريبي</button>
        </div>
    </form>

</div>

@endsection