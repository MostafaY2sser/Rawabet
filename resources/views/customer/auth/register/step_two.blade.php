@extends('customer.layouts.auth')
@section('title')
إنشاء حساب جديد
@endsection
@section('content')
   <div class="auth_page">
        <div class="wrapper verify_identity">


             <div class="logo">
                <img src="{{ asset('assets/images/auth/logo_auth.png') }}" alt="">
            </div>

            <div class="form_box">
                <div class="as_form">

                    <h2 class="text-center">إنشاء حساب جديد</h2>

                    <!-- Steeper -->
                    <div class="stepper mx-0 mx-md-5">
                        <div class="step ">
                            <!-- <div class="circle">1</div> -->
                            <div class="circle" style="background-color: #F5932E;">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1673 7.38723V8.00056C15.1665 9.43818 14.701 10.837 13.8402 11.9884C12.9794 13.1399 11.7695 13.9822 10.3909 14.3898C9.01227 14.7974 7.53882 14.7485 6.1903 14.2503C4.84177 13.7521 3.69042 12.8313 2.90796 11.6253C2.1255 10.4192 1.75385 8.9926 1.84844 7.5581C1.94303 6.1236 2.49879 4.75811 3.43284 3.66528C4.36689 2.57244 5.62917 1.81082 7.03144 1.49399C8.43371 1.17717 9.90083 1.32212 11.214 1.90723" stroke="white" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M6.5 7.33268L8.5 9.33268L15.1667 2.66602" stroke="white" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="label">البيانات الأساسية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step active">
                            <div class="circle">2</div>
                            <div class="label">التحقق من الهوية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle">3</div>
                            <div class="label">إكمال الملف</div>
                        </div>
                    </div>
                    <!-- Steppper -->


                    <div class="conect_platform ">
                        <div class="icon">
                            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M66.6673 43.3342C66.6673 60.0008 55.0007 68.3342 41.134 73.1675C40.4079 73.4136 39.6191 73.4018 38.9007 73.1342C25.0007 68.3342 13.334 60.0008 13.334 43.3342V20.0008C13.334 19.1168 13.6852 18.2689 14.3103 17.6438C14.9354 17.0187 15.7833 16.6675 16.6673 16.6675C23.334 16.6675 31.6673 12.6675 37.4673 7.60085C38.1735 6.99751 39.0718 6.66602 40.0007 6.66602C40.9295 6.66602 41.8278 6.99751 42.534 7.60085C48.3673 12.7008 56.6673 16.6675 63.334 16.6675C64.218 16.6675 65.0659 17.0187 65.691 17.6438C66.3161 18.2689 66.6673 19.1168 66.6673 20.0008V43.3342Z" stroke="#F5932E" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h4>الربط مع منصة أبشر</h4>
                        <h6>سنقوم بالتحقق من هويتك عبر منصة أبشر الرسمية</h6>
                        <p>للتأكد من صحة بياناتك، سيتم توجيهك إلى منصة أبشر للتحقق الرسمي من الهوية</p>
                    </div>

                    <div class="required_info">
                        <h6>ما تحتاجه للتحقق:</h5>
                        <ul>
                            <li> حساب أبشر فعال</li>
                            <li> رقم الهوية الوطنية/الإقامة</li>
                            <li> رقم الهاتف المسجل في أبشر</li>
                        </ul>
                    </div>


                     <a href="{{ route('customer.register.stepTwo.post', $id) }}" class="verify_apsheer" >
                         <p>التحقق عبر أبشر</p>
                         <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M20 13.5005C20 18.5005 16.5 21.0005 12.34 22.4505C12.1222 22.5243 11.8855 22.5207 11.67 22.4405C7.5 21.0005 4 18.5005 4 13.5005V6.50045C4 6.23523 4.10536 5.98088 4.29289 5.79334C4.48043 5.60581 4.73478 5.50045 5 5.50045C7 5.50045 9.5 4.30045 11.24 2.78045C11.4519 2.59945 11.7214 2.5 12 2.5C12.2786 2.5 12.5481 2.59945 12.76 2.78045C14.51 4.31045 17 5.50045 19 5.50045C19.2652 5.50045 19.5196 5.60581 19.7071 5.79334C19.8946 5.98088 20 6.23523 20 6.50045V13.5005Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         </svg>
                    </a>

                    <a href="#" class="back_step">
                        السابق
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.832 8.5H3.16537M3.16537 8.5L7.16536 4.5M3.16537 8.5L7.16536 12.5" stroke="#0C0C0C" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>





                </div>
            </div>

             <p class="hava_account">
                لديك حساب بالفعل؟  <a href="#">قم بتسجيل الدخول</a>
            </p>


        </div>
    
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>

    @endsection