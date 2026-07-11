
                <div class="assigned_consultant section_tap">

                    <h6 class="main_title mb-5">الاستشاري المسؤول</h6>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="perssonal_info">
                                <div class="image">
                                    <img src="{{ Storage::url($project->consultant->avatar) }}" alt="">
                                </div>
                                <h6>{{ $project->consultant->fullname }}</h6>
                                <p>{{ $project->consultant->spciality->name }}</p>
                                <div class="rating">
                                    <img src="../../public/assets/images/home/star.png" alt="">
                                    <h6 class="num"></h6>
                                    <span>({{ rand(0,10) }} معاينة)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="main_info"  >
                                        <h6>المعلومات الأساسية</h6>
                                        <div class="national_id">
                                            <p>رقم الهوية:</p>
                                            <span>{{ $project->consultant->identity_number }} </span>
                                        </div>
                                        <div class="experience">
                                            <p>سنوات الخبرة:</p>
                                            <span>{{ $project->consultant->experience_years }} سنة</span>
                                        </div>
                                        <div class="assigned">
                                            <p>المعايانات المكتملة:</p>
                                            <span>{{ rand(0,15) }} مشروع</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="certifictes">
                                        <h6>الشهادات والاعتمادات</h6>
                                        <div>
                                            <img src="../../public/assets/images/customer/icons/checked.png"
                                                alt="">
                                            <span>{{ $project->consultant->certificates }} </span>
                                        </div>
                                        {{-- <div>
                                            <img src="../../public/assets/images/customer/icons/checked.png"
                                                alt="">
                                            <span>خبير تقييم عقاري</span>
                                        </div>
                                        <div>
                                            <img src="../../public/assets/images/customer/icons/checked.png"
                                                alt="">
                                            <span>استشاري إنشائي</span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 contact_consultant">
                                <div class="col-md-4 d-none">
                                    <a href="#" class="main_btn_bg" id="consultant_message" >
                                        <i class="fa-regular fa-comment"></i>
                                        <span>دردشة مباشرة</span>
                                    </a>
                                </div>
                                @php
                                    $email = $project->consultant->email ?? "";
                                    $phone = $project->consultant->phone_number ?? "";
                                @endphp
                                <div class="col-md-4">
                                    <a href="mailto:{{ $email }}" class="main_btn_bg">
                                        <i class="fa-regular fa-envelope"></i>
                                        <span>إرسال بريد إلكتروني</span>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="tel:{{ $phone }}" class="main_btn_bg">
                                        <i class="fa-solid fa-phone"></i>
                                        <span>{{$phone}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="consultant_message  d-none ">
                        <div class="wrapper">
                            <h6 class="head">
                                <span>إرسال رسالة إلى </span>
                                <span>م. أحمد محمد العلي</span>
                            </h6>

                            <form action="" method="POST">
                                <div class="quick_messages mt-4">
                                    <h6>الرسائل السريعة</h6>
                                    <label for="msg1" class="quick_label">
                                        <input type="radio" hidden id="msg1" name="quick_message" value="هل يمكن تأكيد موعد المعاينة؟">
                                        هل يمكن تأكيد موعد المعاينة؟
                                    </label>

                                    <label for="msg2" class="quick_label">
                                        <input type="radio" hidden id="msg2" name="quick_message" value="أحتاج إلى معلومات إضافية حول المعاينة">
                                        أحتاج إلى معلومات إضافية حول المعاينة
                                    </label>

                                    <label for="msg3" class="quick_label">
                                        <input type="radio" hidden id="msg3" name="quick_message" value="هل هناك أي متطلبات خاصة للمعاينة؟">
                                        هل هناك أي متطلبات خاصة للمعاينة؟
                                    </label>

                                    <label for="msg4" class="quick_label">
                                        <input type="radio" hidden id="msg4" name="quick_message" value="شكراً لكم على خدماتكم">
                                        شكراً لكم على خدماتكم
                                    </label>
                                </div>


                                <div class="input_group textarea">
                                    <label for="message">اكتب رسالتك</label>
                                    <textarea name="message" id="message" placeholder="اكتب رسالتك هنا..."></textarea>
                                </div>

                                <p class="note">ملاحظة: سيتم الرد على رسالتك خلال 2-4 ساعات في أوقات العمل الرسمية.</p>

                                <div class="buttons">
                                    <button class="main_btn_bg">
                                        <i class="fa-brands fa-telegram"></i>
                                        <span>إرسال الرسالة</span>
                                    </button>
                                    <button type="submit" class="main_btn_bg cancel">
                                        <span>إلغاء</span>
                                    </button>
                                </div>
                            </form>

                            <div class="close">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4L4 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 4L12 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>
