@extends('provider.layouts.auth')
@section('title')
    إنشاء حساب جديد
@endsection
@section('styles')
    <!-- CSS الخاص بـ Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
@section('content')






    <div class="auth_page">
        <div class="wrapper rejester">

            <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box ">
                <form action="{{ route('provider.register.stepThree.post', $id) }}" method="POST">
                    <h2>إنشاء حساب جديد كمزود خدمة</h2>

                    @csrf
                    @if ($errors->any())
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
                        <div class="step">
                            <div class="circle"  style="background-color: #F5932E">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.1673 7.38723V8.00056C15.1665 9.43818 14.701 10.837 13.8402 11.9884C12.9794 13.1399 11.7695 13.9822 10.3909 14.3898C9.01227 14.7974 7.53882 14.7485 6.1903 14.2503C4.84177 13.7521 3.69042 12.8313 2.90796 11.6253C2.1255 10.4192 1.75385 8.9926 1.84844 7.5581C1.94303 6.1236 2.49879 4.75811 3.43284 3.66528C4.36689 2.57244 5.62917 1.81082 7.03144 1.49399C8.43371 1.17717 9.90083 1.32212 11.214 1.90723"
                                        stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.5 7.33268L8.5 9.33268L15.1667 2.66602" stroke="white" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="label">البيانات الأساسية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle"  style="background-color: #F5932E">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.1673 7.38723V8.00056C15.1665 9.43818 14.701 10.837 13.8402 11.9884C12.9794 13.1399 11.7695 13.9822 10.3909 14.3898C9.01227 14.7974 7.53882 14.7485 6.1903 14.2503C4.84177 13.7521 3.69042 12.8313 2.90796 11.6253C2.1255 10.4192 1.75385 8.9926 1.84844 7.5581C1.94303 6.1236 2.49879 4.75811 3.43284 3.66528C4.36689 2.57244 5.62917 1.81082 7.03144 1.49399C8.43371 1.17717 9.90083 1.32212 11.214 1.90723"
                                        stroke="white" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.5 7.33268L8.5 9.33268L15.1667 2.66602" stroke="white" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="label">رفع الستندات الرسمية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step active">
                            <div class="circle">3</div>
                            <div class="label">تحديد مجالات التخصص</div>
                        </div>
                    </div>

                    <p class="complete_data">أكمل بياناتك لتتمكن من استخدام جميع خدمات المنصة</p>

                    <div class="specialization-options">
                        <p>تحديد مجالت التخصص (اختيار متعدد):</p>
                        <div class="row">
                            @foreach ($specializations as $specialization)
                                <div class="col-6 col-md-4">
                                    <input type="checkbox" id="sp{{ $specialization->id }}" name="specializations[]" value="{{ $specialization->id }}" hidden />
                                    <label class="specialization-box" for="sp{{ $specialization->id }}">{{ $specialization->name }}</label>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="select_location">
                        <h6>تحديد نطاق العمل الجغرافي</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input_group">
                                    <label for="region_id">المناطق</label>
                                    <select id="region_id" name="region_id[]" class="form-control"  multiple required>
                                      @foreach ($regions as $item)
                                             <option value="{{ $item->id }}">{{ $item->name }}</option>
                                         @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input_group">
                                    <label for="city_id">المدن</label>
                                    <select id="city_id" name="city_id[]" class="form-control" multiple required>
                        
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                    <button type="submit" class="main_bg">التالي</button>

                    <a href="#" class="back_step mt-0">
                        السابق
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.832 8.5H3.16537M3.16537 8.5L7.16536 4.5M3.16537 8.5L7.16536 12.5" stroke="#0C0C0C"
                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                </form>
            </div>

            <p class="hava_account mt-3">
                لديك حساب بالفعل؟ <a href="#">قم بتسجيل الدخول</a>
            </p>


        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>









@endsection

@section('scripts')
    <!-- JS الخاص بـ Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Area
        $(document).ready(function() {
            $('#region_id').select2({
                placeholder: "اختر ",
                width: '100%',
                dir: "rtl"
            });
        });

        // City
        $(document).ready(function() {
            $('#city_id').select2({
                placeholder: "اختر ",
                width: '100%',
                dir: "rtl"
            });
        });
    </script>

      <script>
        $('document').ready(function() {
            // Handle region selection change
            $('#region_id').change(function() {
                var regionId = $(this).val();
                if (regionId) {
                    $.ajax({
                        url: '{{ route('api.cities.byregion') }}',
                        type: 'GET',
                        data: { region_id: regionId },
                        success: function(data) {
                            $('#city_id').empty();
                            $.each(data, function(index, region) {
                                $('#city_id').append('<option value="' + region.id + '">' + region.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#region_id').empty();
                    $('#region_id').append('<option value="" disabled selected>المدينة</option>');
                }
            });
        });
    </script>
@endsection
