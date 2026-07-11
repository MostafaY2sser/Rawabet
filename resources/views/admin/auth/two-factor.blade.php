@extends('provider.layouts.auth')
@section('title')
    التحقق بخطوتين
@endsection

@section('content')
    <div class="auth_page">
        <div class="wrapper login">
            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box">
                <form action="{{ route('admin.2fa.verify') }}" method="POST">
                    @csrf
                    <h2>التحقق بخطوتين</h2>
                    <p class="welcome_back">أدخل رمز التحقق المرسل إلى بريدك الإلكتروني.</p>

                    @if($errors->any())
                        <div class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="input_error" style="background: #ecfdf3; color: #047857;">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="input_group">
                        <label for="code">رمز التحقق</label>
                        <input type="text" name="code" id="code" placeholder="000000" maxlength="6" required>
                    </div>

                    <button type="submit">تأكيد الرمز</button>
                </form>

                <form action="{{ route('admin.2fa.resend') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit">إعادة إرسال الرمز</button>
                </form>
            </div>
        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">
    </div>
@endsection
