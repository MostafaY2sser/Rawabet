@extends('customer.layouts.auth')
@section('title')
إنشاء حساب جديد
@endsection
@section('content')
<div class="auth_page">
        <div class="wrapper rejester">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

             <div class="form_box ">
                <form action="{{ route('customer.register.stepOne') }}" method="POST">
                    <h2>إنشاء حساب جديد</h2>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <!-- Stepper -->
                    <div class="stepper  mx-0 mx-md-5">
                        <div class="step active">
                            <div class="circle">1</div>
                            <div class="label">البيانات الأساسية</div>
                        </div>
                        {{-- <div class="line"></div>
                        <div class="step">
                            <div class="circle">2</div>
                            <div class="label">التحقق من الهوية</div>
                        </div> --}}
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle">3</div>
                            <div class="label">إكمال الملف</div>
                        </div>
                    </div>

                    <div class="input_group">
                        <label for="full_name">الاسم كامل*</label>
                        <input type="text" value="{{ @old('full_name') }}" name="full_name" id="full_name" placeholder="الاسم كامل" required>
                    </div>
                    <div class="input_group">
                        <label for="national_id">رقم الهوية الوطنية/الإقامة*</label>
                        <input type="text" value="{{ @old('national_id') }}" name="national_id" id="national_id" placeholder="1234567890" required >
                    </div>
                    <div class="input_group">
                        <label for="phone_number">رقم الهاتف المحمول*</label>
                        <input type="text" value="{{ @old('phone_number') }}" name="phone_number" id="phone_number" placeholder="+966 50 123 4567" required >
                        <button class="confirm_phone">التحقق من الهاتف المحمول</button>
                    </div>
                    <div class="input_group">
                        <label for="email">البريد الإلكتروني*</label>
                        <input type="email" value="{{ @old('email') }}" name="email" id="email" placeholder="example@mail.com" required >
                    </div>
                    <div class="input_group">
                        <label for="password">كلمة المرور*</label>
                        <div class="password_wrapper position-relative">
                            <input type="password" name="password" id="password" placeholder="أدخل كلمة مرور قوية" required>
                            <span class="password_toggle">
                                <!-- Eye Open -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="eyeOpen" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Eye Closed -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="eyeClosed d-none" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.738-4.078M6.708 6.708A9.965 9.965 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.664 3.003M3 3l18 18"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="confirm_password">تأكيد كلمة المرور*</label>
                        <div class="password_wrapper position-relative">
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="تأكيد كلمة المرور" required >
                            <span class="password_toggle">
                                <!-- Eye Open -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="eyeOpen" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Eye Closed -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="eyeClosed d-none" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a10.05 10.05 0 012.738-4.078M6.708 6.708A9.965 9.965 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.664 3.003M3 3l18 18"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="agree_terms">
                        <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                        <label for="agree_terms">
                            <p>أوافق علي  <a href="#">شرو وأحكام المنصة</a></p>
                        </label>
                    </div>

                    <button type="submit" class="main_bg">التالي - التحقق من الهوية</button>


                </form>
            </div>

            <p class="hava_account">
                لديك حساب بالفعل؟  <a href="{{route('customer.login')}}">قم بتسجيل الدخول</a>
            </p>


        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>

    <script src="../../../../../assets/js/password-toggle.js"></script>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
        const errors = [];

        const fullName = document.getElementById("full_name").value.trim();
        const nationalId = document.getElementById("national_id").value.trim();
        const phoneNumber = document.getElementById("phone_number").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const agreeTerms = document.getElementById("agree_terms").checked;

        // Full name required
        if (fullName === "") {
            errors.push("يرجى إدخال الاسم الكامل.");
        }

        // National ID: required and 10 digits
        if (!/^\d{10}$/.test(nationalId)) {
            errors.push("رقم الهوية يجب أن يكون مكونًا من 10 أرقام.");
        }

        // Saudi mobile number format
        if (!/^0?5\d{8}$/.test(phoneNumber)) {
            errors.push("يرجى إدخال رقم جوال سعودي صحيح يبدأ بـ 5 ويتكون من 9 أرقام.");
        }

        // Email format
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)) {
            errors.push("يرجى إدخال بريد إلكتروني صالح.");
        }

        // Password minimum length
        if (password.length < 8) {
            errors.push("كلمة المرور يجب أن تكون 8 أحرف على الأقل.");
        }

        // Password match
        if (password !== confirmPassword) {
            errors.push("كلمتا المرور غير متطابقتين.");
        }

        // Terms checkbox
        if (!agreeTerms) {
            errors.push("يجب الموافقة على الشروط والأحكام.");
        }

        if (errors.length > 0) {
            e.preventDefault();

            let alertBox = document.querySelector(".alert.alert-danger");
            if (!alertBox) {
                alertBox = document.createElement("div");
                alertBox.className = "alert alert-danger";
                form.prepend(alertBox);
            }

            alertBox.innerHTML = "<ul>" + errors.map(e => `<li>${e}</li>`).join('') + "</ul>";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });
});
</script>



@endsection