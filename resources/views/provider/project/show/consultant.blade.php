
                <div class="assigned_consultant content_tap d-none">

                    <h6 class="main_title mb-5">الاستشاري المسؤول</h6>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="perssonal_info">
                                <div class="image">
                                    <img src="{{ $project->consultant->avatar }}" alt="">
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
                                    <div class="main_info">
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
                                    <a href="#" class="main_btn_bg">دردشة مباشرة</a>
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

                </div>
