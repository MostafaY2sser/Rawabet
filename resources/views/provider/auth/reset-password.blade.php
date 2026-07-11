@extends('provider.layouts.auth')
@section('title')
    تعيين كلمة مرور جديدة
@endsection

@section('content')
    <div class="auth_page">
        <div class="wrapper login">
            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box">
                <form action="{{ route('provider.password.reset') }}" method="POST">
                    @csrf
                    <h2>تعيين كلمة مرور جديدة</h2>
                    <p class="welcome_back">أدخل كلمة مرور جديدة لحسابك.</p>

                    @if($errors->any())
                        <div class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="input_group">
                        <label for="password">كلمة المرور الجديدة</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="input_group">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <button type="submit">حفظ كلمة المرور</button>
                </form>
            </div>
        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">
    </div>
@endsection
