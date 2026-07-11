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
                <form action="{{ route('provider.register.stepTwo.post' , $id) }}" method="POST" enctype="multipart/form-data">
                    <h2>إنشاء حساب جديد كمزود خدمة</h2>

                    <!-- Stepper -->
                      @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="stepper  mx-0 mx-md-5">
                        <div class="step">
                            <div class="circle" style="background-color: #F5932E">
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
                            <div class="label">رفع الستندات الرسمية</div>
                        </div>
                        <div class="line"></div>
                        <div class="step">
                            <div class="circle">3</div>
                            <div class="label">تحديد مجالات التخصص</div>
                        </div>
                    </div>

                    @csrf

                    <div class="upload_documents">
                        <label class="file-label">*صورة من السجل التجاري</label>

                        <label class="upload_documents_box" for="fileInput1">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input  type="file" name="image_commercial_registration" id="fileInput1" accept=".jpg,.jpeg,.png,.pdf" style="opacity: 0"  >
                        </label>

                    </div>

                    

                    <div class="upload_documents">
                        <label class="file-label">*شهادة الزكاة والدخل</label>
                        <label class="upload_documents_box" for="fileInput2">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="zakat_income" id="fileInput2" accept=".jpg,.jpeg,.png,.pdf" style="opacity: 0" >
                        </label>
                    </div>


                     <div class="upload_documents">
                        <label class="file-label">*شهادة الاشتراك في الغرفة التجارية</label>

                        <label class="upload_documents_box" for="fileInput3">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="chamber_certificate" id="fileInput3" accept=".jpg,.jpeg,.png,.pdf" style="opacity: 0"  >
                        </label>

                    </div>


                     <div class="upload_documents">
                        <label class="file-label">*شهادة السعودة</label>

                        <label class="upload_documents_box" for="fileInput4">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="saudization_certificate" id="fileInput4" accept=".jpg,.jpeg,.png,.pdf" style="opacity: 0"  >
                        </label>

                    </div>



                    <div class="upload_documents">
                        <label class="file-label">*التأمينات الاجتماعية</label>

                        <label class="upload_documents_box" for="fileInput5">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="social_insurance[]" id="fileInput5" accept=".jpg,.jpeg,.png,.pdf" multiple style="opacity: 0" >
                        </label>
                    </div>

                    <script>
                    const fileInput = document.getElementById('fileInput5');

                    fileInput.addEventListener('change', function() {
                        if (this.files.length < 2) {
                            alert('يجب رفع ملفين علي الاقل!');
                            this.value = ''; 
                        }
                    });
                    </script>

                    


                     <div class="upload_documents">
                        <label class="file-label">*شهادة العنوان الوطني</label>

                        <label class="upload_documents_box" for="fileInput6">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="national_address" id="fileInput6" accept=".jpg,.jpeg,.png"  style="opacity: 0" >
                        </label>

                    </div>
                    

                    <div class="upload_documents">
                        <label class="file-label">*التراخيص المهنية</label>

                        <label class="upload_documents_box" for="fileInput7">
                            <div class="icon">                              
                                <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M28.8799 20.9V26.2334C28.8799 26.9406 28.5989 27.6189 28.0988 28.119C27.5987 28.6191 26.9205 28.9 26.2132 28.9H7.54655C6.83931 28.9 6.16103 28.6191 5.66093 28.119C5.16083 27.6189 4.87988 26.9406 4.87988 26.2334V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23.5465 11.5667L16.8798 4.90002L10.2131 11.5667" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.8799 4.90002V20.9" stroke="#9CA3AF" stroke-width="2.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>  
                            </div>
                            <p>اسحب الملفات هنا أو انقر للتحميل</p>
                            <div class="file-note">PDF, JPG, PNG (حد أقصى 10 ميجابايت)</div>
                            <input type="file" name="professional_licenses[]" id="fileInput7" accept=".jpg,.jpeg,.png,.pdf" multiple style="opacity: 0" >
                        </label>

                    </div>
                    

                    <button type="submit" class="main_bg">التالي</button>


                    <a href="#" class="back_step mt-0">
                        السابق
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.832 8.5H3.16537M3.16537 8.5L7.16536 4.5M3.16537 8.5L7.16536 12.5" stroke="#0C0C0C" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>


                </form>
            </div>

            <p class="hava_account mt-3">
                لديك حساب بالفعل؟  <a href="#">قم بتسجيل الدخول</a>
            </p>


        </div>
        <img src="{{ asset('assets/images/auth/bg_auth.png') }}" alt="" class="bg_auth d-none d-lg-block">

    </div>



    <script src="{{ asset('assets/js/provider/provider.js') }}"></script>
     
@endsection