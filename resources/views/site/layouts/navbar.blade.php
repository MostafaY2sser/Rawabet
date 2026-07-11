

<style>

</style>



<div class="container-fluid ">
        <header>
            <div class="header px-0 px-lg-4">


                 <div class="right">
                    <a href="/" class="logo">
                        {{-- <img src="{{asset('assets\images\home\main_logo.png')}}" alt=""> --}}
                        <img src="{{asset('assets\images\home\main_logo_2.png')}}" alt="">
                        <div>
                            <h3> روابط الإعمار </h3>
                            <h3>Emaar Links</h3>
                        </div>
                    </a>
                    <nav>
                        <ul>
                            <li>
                                <a href="{{route('contact.us')}}" class="{{ request()->routeIs('contact.us') ? 'active' : '' }}">تواصل معنا</a>
                            </li>
                            <li>
                                <a href="{{route('providers.list')}}" class="{{ request()->routeIs('providers.*') ? 'active' : '' }}">مزودي الخدمات</a>
                            </li>
                            <li>
                                <a href="{{route('projects.list')}}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"> تصفح المشاريع</a>
                            </li>
                            <li>
                                <a href="#">عن المنصة</a>
                            </li>
                            <li>
                                <a href="{{route('home')}}" class="{{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>
                            </li>
                        </ul>
                    </nav>
                </div>


                <div class="left  ">
                    <div class="lang">
                        {{-- ------------------------------------------ --}}
                        <!-- Dropdown -->
                        {{-- <div class=" current_lang small_dropdown">
                            <button class="small_dropdown_btn">
                                <i class="fa-solid fa-globe"></i>
                                <span>English</span>
                            </button>
                            <div class="small_dropdown_content">
                                <button>العربية</button>
                                <button>English</button>
                            </div>
                        </div> --}}
                        {{-- ------------------------------------------ --}}
                    </div>
                    <a href="{{route('customer.login')}}" class="main_button">
                        <span>تسجيل دخول</a>
                    </a>
                    <a href="{{route('customer.register')}}" class="main_button_bg">
                        <span>حساب جديد</a>
                    </a>
                </div>



                <div class="icon_bar">
                    <i class="fa-solid fa-bars"></i>
                </div>
               


                {{-- Mobile Nav --}}
                    <div class="mobile_nav">
                        <div class="wrapper">
                            <nav>
                                <ul>
                                    <li>
                                        <a href="{{route('home')}}" class="{{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>
                                    </li>
                                    <li>
                                        <a href="#">عن المنصة</a>
                                    </li>
                                    <li>
                                        <a href="{{route('projects.list')}}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}"> تصفح المشاريع</a>
                                    </li>
                                    <li>
                                        <a href="{{route('providers.list')}}" class="{{ request()->routeIs('providers.*') ? 'active' : '' }}" >مزودي الخدمات</a>
                                    </li>
                                    <li>
                                        <a href="{{route('contact.us')}}" class="{{ request()->routeIs('contact.us') ? 'active' : '' }}" >تواصل معنا</a>
                                    </li>
                                </ul>
                            </nav>

                            <div class="buttons">
                                <a href="{{route('customer.register')}}" class="main_button_bg">
                                    <span>حساب جديد</a>
                                </a>
                                <a href="{{route('customer.login')}}" class="main_button">
                                    <span>تسجيل دخول</a>
                                </a>
                            </div>

                            <div class="close_bar">
                                <i class="fa-solid fa-xmark"></i>
                            </div>

                        </div>
                    </div>
                {{-- Mobile Nav --}}



            </div>
        </header>
    </div>


<script>
    
</script>


