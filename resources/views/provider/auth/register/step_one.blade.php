@extends('provider.layouts.auth')
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
                <form action="{{ route('provider.register.stepOne') }}" method="POST">
                    <h2>إنشاء حساب جديد كمزود خدمة</h2>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Stepper -->

                    <div class="stepper  mx-0 mx-md-5">
                        <div class="step active">
                            <div class="circle">1</div>
                            <div class="label">البيانات الأساسية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle">2</div>
                            <div class="label">رفع الستندات الرسمية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle">3</div>
                            <div class="label">تحديد مجالات التخصص</div>
                        </div>
                    </div>

                    @csrf
                    <div class="input_group">
                        <label for="company_name">*اسم الشركة/المؤسسة</label>
                        <input type="text" value="{{ old('company_name') }}" name="company_name" id="company_name" placeholder="اسم الشركة/المؤسسة" required>
                    </div>
                    <div class="input_group">
                        <label for="legal_entity_type">نوع الكيان القانوني*</label>
                        <select name="legal_entity_type" id="legal_entity_type" required >
                            <option value="" disabled selected >نوع الكيان</option>
                            <option value="1" {{ old('legal_entity_type') == 1 ? 'selected' : '' }}>test 1</option>
                            <option value="2" {{ old('legal_entity_type') == 2 ? 'selected' : '' }}>test_2</option>
                            <option value="3" {{ old('legal_entity_type') == 3 ? 'selected' : '' }}>test_3</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="input_group">
                                <label for="owner_id">*رقم الهوية/القامة للمالك</label>
                                <input type="text" name="owner_id" id="owner_id" placeholder="1234567890" maxlength="10" required >
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input_group">
                                <label for="commercial_registration">*رقم السجل التجاري</label>
                                <input type="text" name="commercial_registration" id="commercial_registration" placeholder="1234567890" maxlength="10"  required >
                            </div>
                        </div>
                    </div>
                    <div class="input_group">
                        <label for="phone">رقم الهاتف المحمول*</label>
                        <input value="{{ old('phone_number') }}" type="text" name="phone_number" id="phone_number" placeholder="+966 50 123 4567" required >
                        <button class="confirm_phone">التحقق من الهاتف المحمول</button>
                    </div>
                    <div class="input_group">
                        <label for="email">البريد الإلكتروني*</label>
                        <input value="{{ old('email') }}" type="email" name="email" id="email" placeholder="example@mail.com" required >
                    </div>
                     <div class="input_group">
                        <label for="password">كلمة المرور*</label>
                        <div class="password_wrapper position-relative">
                            <input type="password" name="password" id="password" placeholder="أدخل كلمة المرور" required >
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
                        <label for="password_confirmation"> تاكيد كلمة المرور*</label>
                        <div class="password_wrapper position-relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="أدخل كلمة المرور" required >
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
                        <label for="address">*العنوان الكامل</label>
                        <input value="{{ old('address') }}" type="text" name="address" id="address" placeholder="أدخل العنوان التفصيلي" required >
                    </div>
                    <div class="row">
                          <div class="col-md-6">
                            <div class="input_group">
                                <label for="region_id">المنطقة</label>
                                <select name="region_id" id="region_input" required>
                                    <option value="" disabled selected>المنطقة</option>
                                      @foreach($regions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input_group">
                                <label for="city_id">المدينة</label>
                                <select name="city_id" id="city_input" required>
                                    <option value="" disabled selected>المدينة</option>
                                  
                                </select>
                            </div>
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

            <p class="hava_account mt-3">
                لديك حساب بالفعل؟  <a href="{{route('provider.login')}}">قم بتسجيل الدخول</a>
            </p>


        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>

    <script src="../../../../../assets/js/password-toggle.js"></script>

@endsection


 @section('scripts')
   
    <script>
        $('document').ready(function() {
            // Handle region selection change
            $('#region_input').change(function() {
                var regionId = $(this).val();
                if (regionId) {
                    $.ajax({
                        url: '{{ route('api.cities.byregion') }}',
                        type: 'GET',
                        data: {
                            region_id: regionId
                        },
                        success: function(data) {
                            $('#city_input').empty();
                            $('#city_input').append(
                                '<option value="" disabled selected>المنطقة</option>');
                            $.each(data, function(index, city) {
                                $('#city_input').append('<option value="' + city
                                    .id + '">' + city.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city_input').empty();
                    $('#city_input').append('<option value="" disabled selected>المدينة</option>');
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    console.log(form)
    const phoneInput = document.getElementById('phone_number');

    form.addEventListener('submit', function (e) {
        const errors = [];

        const companyName = document.getElementById('company_name');
        const legalEntity = document.getElementById('legal_entity_type');
        const ownerId = document.getElementById('owner_id');
        const crNumber = document.getElementById('commercial_registration');
        const phone = document.getElementById('phone_number');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const address = document.getElementById('address');
        const region = document.getElementById('region_input');
        const city = document.getElementById('city_input');
        const terms = document.getElementById('agree_terms');
        const password_confirmation  = document.getElementById("password_confirmation");
        const saudiPhoneRegex =/^0?5\d{8}$/;
        const saudiIdRegex = /^\d{10}$/;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


        // Basic required checks
        if (!companyName.value.trim()) errors.push("الرجاء إدخال اسم الشركة.");
        if (!legalEntity.value) errors.push("الرجاء اختيار نوع الكيان القانوني.");
        if (!ownerId.value.trim() || !saudiIdRegex.test(ownerId.value)) errors.push("رقم هوية المالك يجب أن يكون مكونًا من 10 أرقام.");
        if (!crNumber.value.trim() || !saudiIdRegex.test(crNumber.value)) errors.push("رقم السجل التجاري يجب أن يكون مكونًا من 10 أرقام.");
        if (!phone.value.trim() || !saudiPhoneRegex.test(phone.value)) errors.push("رقم الجوال يجب أن يبدأ بـ 05 ويتكون من 10 أرقام.");
        if (!email.value.trim() || !emailRegex.test(email.value)) errors.push("يرجى إدخال بريد إلكتروني صالح.");
        if (!password.value.trim()) errors.push("يرجى إدخال كلمة المرور.");
        if (!address.value.trim()) errors.push("يرجى إدخال العنوان الكامل.");
        if (!region.value) errors.push("يرجى اختيار المنطقة.");
        if (!city.value) errors.push("يرجى اختيار المدينة.");
        if (!terms.checked) errors.push("يجب الموافقة على الشروط والأحكام.");
        if(password.value != password_confirmation.value) errors.push("كلمة المرور يجب ان تكون متطابقة")
        // Display errors if any
        if (errors.length > 0) {
            e.preventDefault();

            // Clear any previous alerts
            const oldAlert = document.querySelector('.alert.alert-danger');
            if (oldAlert) oldAlert.remove();

            const alertBox = document.createElement('div');
            alertBox.classList.add('alert', 'alert-danger');

            const ul = document.createElement('ul');
            errors.forEach(err => {
                const li = document.createElement('li');
                li.innerText = err;
                ul.appendChild(li);
            });

            alertBox.appendChild(ul);
            form.insertBefore(alertBox, form.querySelector('.stepper'));
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // Optional: format phone as the user types (restrict to 10 digits)
    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^\d]/g, '').slice(0, 10);
    });
});
</script>

@endsection