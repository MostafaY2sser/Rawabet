@extends('provider.layouts.auth')
@section('title')
    استعادة كلمة المرور
@endsection

@section('content')
    <div class="auth_page">
        <div class="wrapper login">
            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box ">
                <form action="{{ route('provider.password.send.code') }}" method="POST">
                    @csrf
                    <h2>استعادة كلمة المرور</h2>
                    <p class="welcome_back">أدخل بريدك الإلكتروني لإرسال رمز التحقق.</p>

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
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <button type="submit">إرسال الرمز</button>
                </form>
            </div>
        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">
    </div>
@endsection
