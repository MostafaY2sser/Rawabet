@extends('customer.layouts.auth')
@section('title')
    تسجيل الدخول
@endsection


{{-- FontAwsome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


@section('content')
    <div class="auth_page">
        <div class="wrapper login">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}"  alt="logo">
            </div>

            <div class="form_box ">
                <form action="{{ route('customer.login.post') }}" method="POST">
                    @csrf
                    <h2>تسجيل الدخول</h2>
                    <p class="welcome_back">أهلاً بك من جديد! يُرجى تسجيل الدخول للمتابعة.</p>

                    {{-- Inputs Erorr --}}
                     @if($errors->any())
                        <div  class="input_error">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="input_group">
                        <label for="email">البريد الالكتروني</label>
                        <input type="email" name="email" id="email" placeholder="البريد الالكتروني" required>
                    </div>
                    <div class="input_group">
                        <div class="icon_eye">
                            <i class="fa-regular fa-eye" id="showEye"></i>
                            <i class="fa-regular fa-eye-slash d-none" id="hideEye"></i>
                        </div>
                        <label for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password" placeholder="كلمة المرور" required>
                    </div>

                    <div class="forget_password">
                        <a href="{{ route('customer.password.forgot') }}">نسيت كلمة المرور الخاصة بك</a>
                    </div>

                    <button type="submit">تسجيل الدخول</button>

                </form>
            </div>

            <div class="go_signup">
                <p>ليس لديك حساب؟ <a href="{{route('customer.register')}}">قم بالتسجيل الان</a> </p>
            </div>

            <div class="or">او</div>

            <a href="{{route('provider.login')}}" class="login_provider">سجل كمزود خدمة</a>

            <p class="tip px-2 px-md-0">من خلال الاستمرار، فإنك توافق على شروط الخدمة وسياسة الخصوصية الخاصة بـ روابط
                الاعمار وتوافق على تلقي رسائل بريد إلكتروني دورية تحتوي على التحديثات.</p>

        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">
    </div>


    <script src="../../../../assets/js/customer/customer.js"></script>

@endsection
