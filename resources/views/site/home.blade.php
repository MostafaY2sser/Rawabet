@extends('site.layouts.main')
@section('title', 'Home')

@section('content')


    <!-- Hero Setion -->
    <div class="container">
        <div class="hero_section">
            <div class="top">
                <h1>منصة روابط الإعمار</h1>
                <p class="desc">منصة متكاملة توفر لك أفضل المقاولين المعتمدين في <br> المملكة العربية السعودية، مع ضمان أعلى
                    معايير الجودة والشفافية في كل خطوة من <br> مراحل التنفيذ.</p>
                <div class="main_rateing">
                    <div class="rate">
                        <div class="stars">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                        </div>
                        <p> <span>2k+</span> satisfied customers</p>
                    </div>
                    <div class="persone">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">
                        
                    </div>
                    <span class="num">4.9</span>
                </div>
                <div class="buttons">
                    <a href="{{route('customer.register')}}" class="main_button_bg">ابدأ مشروعك الآن </a>
                    <a href="{{route('provider.register')}}" class="main_button">انضم كمقاول</a>
                </div>
            </div>
            <div class="row bottom">
                <div class="col-md-6">
                    <div class="left ">
                        <a href="#" class="small_main_button hero">معلومات عنا</a>
                        <h1 class="main_title">كيف تعمل منصة  روابط الإعمار؟</h1>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="right">
                        <h3>عن منصة روابط الإعمار</h3>
                        <p class="mb-4">منصة "روابط الإعمار" هي الجسر الرقمي الذي يربط بين أصحاب المشاريع وأفضل مقدمي الخدمات في قطاع
                            المقاولات المعتمدين في المملكة العربية السعودية. نقدم حلاً شاملاً يسهل عملية البحث، المقارنة،
                            والتعاقد مع مقدمي خدمات موثوقين لتنفيذ مشاريع البناء، الترميم، والتشطيب بكفاءة وشفافية.</p>
                        <p>تم تصميم المنصة لضمان جودة التنفيذ من خلال نظام تقييم صارم، متابعة فنية دقيقة، وإدارة مالية آمنة.
                            نسعى إلى تحويل تجربة التعامل مع مقاولي البناء إلى عملية سهلة، مضمونة، وخالية من التعقيدات، مما
                            يسهم في تنمية القطاع الإنشائي ويدعم رؤية المملكة 2030.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Setion -->

    <!-- Features Section -->
    <div class="container">
        <div class="features my-3 my-md-5">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="feature mb-4 mb-lg-0">
                        <img src="{{ asset('assets/images/home/features_1.png') }}" alt="">

                        <div class="text">
                            <h4>نظام إلكتروني متقدم</h4>
                            <p>سهولة التنفيذ و المتابعة من خلال النظام الإلكتروني المتقدم.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature mb-4 mb-lg-0">
                        <img src="{{ asset('assets/images/home/features_2.png') }}" alt="">

                        <div class="text">
                            <h4>شفافية مطلقة</h4>
                            <p>شفافية كاملة في التسعير، الجودة، وجدولة المشاريع.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature mb-4 mb-lg-0">
                        <img src="{{ asset('assets/images/home/features_3.png') }}" alt="">

                        <div class="text">
                            <h4>حماية مدفوعاتك</h4>
                            <p>حماية المدفوعات عبر نظام دفعات مرتبطة بمراحل التنفيذ.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature mb-4 mb-lg-0">
                        <img src="{{ asset('assets/images/home/features_4.png') }}" alt="">

                        <div class="text">
                            <h4>فريق دعم متخصص</h4>
                            <p>دعم فني وإداري خلال جميع مراحل المشروع.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features Section -->

    <!-- Add Partener Section -->
    <div class="container">
        <div class="add_partener">
            <div class="text">
                <a href="{{route('provider.register')}}" class="small_main_button">سجل كمزود خدمة</a>
                <h1 class="main_title">انضم كشريك معتمد</h1>
                <p>هل تمتلك مكتبًا هندسيًا أو شركة مقاولات وتريد الوصول إلى آلاف المشاريع؟</p>
                <ul class="mt-4 mt-md-5">
                    <li>
                        <i class="fa-solid fa-check"></i>
                        <span>اعرض خدماتك على أكبر منصة مقاولين في السعودية</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-check"></i>
                        <span>احصل على مشاريع تناسب تخصصك</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-check"></i>
                        <span>زد من أرباحك عبر نظام عمولات تنافسي</span>
                    </li>
                </ul>
                <a href="{{route('provider.register')}}" class="main_button_bg ">سجّل الآن</a>
            </div>
            <div class="image">
                <img src="{{ asset('assets/images/home/add_partener.png') }}" alt="add-partener">

            </div>
            <img src="{{ asset('assets/images/home/angle_img.png') }}" alt="" class="angle_img">

        </div>
    </div>
    <!-- Add Partener Section -->



    <!-- Project Categories  Section   -->
    <div class="project_categories">
        <div class="container">

            <div class="wrapper">
                <div class="head">
                    <div class="small_main_button">تصنيفات المشاريع</div>
                    <h1 class="main_title">ابحث، اختر، وانطلق <br> تصنيفات شاملة لجميع احتياجات البناء</h1>
                </div>

                <div class="categories">
                    <div class="row">
                        @foreach($projectTypes as $type)
                             <div class="col-md-6 col-lg-4">
                            <div class="categorie">
                                <div class="icons">
                                    <img src="{{ asset('assets/images/home/project-categories/big_icon.png') }}" alt="">
                                    <img src="{{ asset('assets/images/home/project-categories/small_icon.png') }}" alt="">
                                </div>
                                <div class="text">
                                    <h5> {{ $type->name }}</h5>
                                    <p>{{$type->description}}</p>
                                </div>
                                <div class="buttons">
                                    <div class="project_num">
                                        <span>{{ $type->projects_count }}+</span>
                                        <span>مشروع</span>
                                    </div>
                                    <a href="#" class="explor">
                                        <span>استكشف</span>
                                        <i class="fa-solid fa-angle-left"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <a href="{{route('customer.register')}}" class="main_button_bg">ابدأ مشروعك الآن</a>

            </div>

        </div>
    </div>
    <!-- Project Categories  Section   -->




    <!-- Project List Section -->
    <div class="project_list">
        <div class="container">
            <div class="main_head">
                 <div class="text">
                    <button class="small_main_button">أحدث المشاريع</button>
                    <h1 class="main_title mt-3">قائمة المشاريع</h1>
                </div>
                <div class="scroll_arrow">
                    <a href="{{route('projects.list')}}" class="show_all">عرض جميع المشاريع</a>
                    <div class="arrows">
                        <div class="right_arrow"  id="rightArrowProject">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="left_arrow"  id="leftArrowProject">
                            <i class="fa-solid fa-angle-left"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="projects" id="projectsSlider">
                @foreach ($projects as $project)
                    @include('site.components.project-card', ['project' => $project])
                @endforeach
            </div>
        </div>
    </div>
    <!-- Project List Section -->




    <!-- Service Provider Section -->
    <div class="service_providers">
        <div class="container">
            <!-- Head -->
            <div class="main_head">
                <div class="text">
                    <button class="small_main_button">منشــآت المقــاولات</button>
                    <h1 class="main_title mt-3">مزودي الخدمات</h1>
                </div>
                <div class="scroll_arrow">
                    <a href="{{route('providers.list')}}" class="show_all">عرض جميع مزودي الخدمات</a>
                    <div class="arrows">
                        <div class="right_arrow" id="rightArrowProvider">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="left_arrow" id="leftArrowProvider">
                            <i class="fa-solid fa-angle-left"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="providers"  id="providersSlider">
                @foreach ($providers as $provider)
                    @include('site.components.provider-card' , ['provider'=>$provider])
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service Provider  Section -->



    
    <!-- Testimonials  Section -->
    <div class="testimonials">
        <div class="container">

            <div class="head">
                <div class="small_main_button">شهادات العملاء</div>
                <h1 class="main_title">تعليقات المستخدمين السعداء</h1>
                <div class="main_rateing">
                    <div class="rate">
                        <div class="stars">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">
                            <img src="{{ asset('assets/images/home/star.png') }}" alt="">

                        </div>
                        <p> <span>2k+</span> satisfied customers</p>
                    </div>
                    <div class="persone">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">
                        <img src="{{ asset('assets/images/home/pepole_rate.png') }}" alt="">

                    </div>
                    <span class="num">4.9</span>
                </div>
            </div>

            <div class="testimonials_boxs">
                <div class="box">

                    <img src="{{asset('assets/images/home/pepole_rate.png')}}" alt="">
                    <p>"تجربتي الأولى في الترميم كانت مخيفة حتى تعرفت على المنصة! الدعم الفني رافقني خطوة بخطوة، والمقاول
                        المختار التزم بالتصميم الذي حلمت به. الأهم أنني دفعت فقط عند إنجاز كل مرحلة - بدون مفاجآت في
                        التكلفة."</p>
                    <div class="name">
                        <h6>علي القحطاني</h6>
                        <span>صاحب متجر ملابس</span>
                    </div>
                </div>
                <div class="box">
                    <img src="{{asset('assets/images/home/pepole_rate.png')}}" alt="">
                    <p>"تجربتي الأولى في الترميم كانت مخيفة حتى تعرفت على المنصة! الدعم الفني رافقني خطوة بخطوة، والمقاول
                        المختار التزم بالتصميم الذي حلمت به. الأهم أنني دفعت فقط عند إنجاز كل مرحلة - بدون مفاجآت في
                        التكلفة."</p>
                    <div class="name">
                        <h6>علي القحطاني</h6>
                        <span>صاحب متجر ملابس</span>
                    </div>
                </div>
                <div class="box">
                    <img src="{{asset('assets/images/home/pepole_rate.png')}}" alt="">
                    <p>"تجربتي الأولى في الترميم كانت مخيفة حتى تعرفت على المنصة! الدعم الفني رافقني خطوة بخطوة، والمقاول
                        المختار التزم بالتصميم الذي حلمت به. الأهم أنني دفعت فقط عند إنجاز كل مرحلة - بدون مفاجآت في
                        التكلفة."</p>
                    <div class="name">
                        <h6>علي القحطاني</h6>
                        <span>صاحب متجر ملابس</span>
                    </div>
                </div>
                <div class="box">
                    <img src="{{asset('assets/images/home/pepole_rate.png')}}" alt="">
                    <p>"تجربتي الأولى في الترميم كانت مخيفة حتى تعرفت على المنصة! الدعم الفني رافقني خطوة بخطوة، والمقاول
                        المختار التزم بالتصميم الذي حلمت به. الأهم أنني دفعت فقط عند إنجاز كل مرحلة - بدون مفاجآت في
                        التكلفة."</p>
                    <div class="name">
                        <h6>علي القحطاني</h6>
                        <span>صاحب متجر ملابس</span>
                    </div>
                </div>
                <div class="box">
                    <img src="{{asset('assets/images/home/pepole_rate.png')}}" alt="">
                    <p>"تجربتي الأولى في الترميم كانت مخيفة حتى تعرفت على المنصة! الدعم الفني رافقني خطوة بخطوة، والمقاول
                        المختار التزم بالتصميم الذي حلمت به. الأهم أنني دفعت فقط عند إنجاز كل مرحلة - بدون مفاجآت في
                        التكلفة."</p>
                    <div class="name">
                        <h6>علي القحطاني</h6>
                        <span>صاحب متجر ملابس</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Testimonials  Section -->


    <!-- FAQ Section  -->
    <div id="faqs">
        @include('site.components.faq')
    </div>
    <!-- FAQ Section  -->




@endsection
@push('scripts')