
@extends('provider.layouts.main')
@section('content')
  


    <div class="available_projects" id="main_page">


        <div class="head ">
            <div class="text">
                <h3>المشاريع المتاحة</h3>
                <p>تصفح المشاريع المتاحة وقدم عرضك الآن! سيتم إعلامك فورًا عند فوزك بالمشروع.</p>
            </div>

                
                <div class="dropdown-container d-none">
                    <div class="dropdown-button" id="dropdownButton">
                    <i class="fa-solid fa-caret-down icon"></i>
                        <div class="dropdown-text">
                            <span class="label">عرض:</span>
                            <span id="selectedText">هذا الشهر</span>
                        </div>
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-item selected" data-value="هذا الشهر">هذا الشهر</div>
                        <div class="dropdown-item" data-value="هذا الاسبوع">هذا الاسبوع</div>
                        <div class="dropdown-item" data-value="هذا اليوم">هذا اليوم</div>
                    </div>
                </div>


        </div>

        <div class="filter_frojects">
            <div class="title">
               <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_2140_565)">
                <path d="M18.5334 3.2998H1.8667L8.53337 11.1831V16.6331L11.8667 18.2998V11.1831L18.5334 3.2998Z" stroke="#4B5563" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                </g>
                <defs>
                <clipPath id="clip0_2140_565">
                <rect width="20" height="20" fill="white" transform="translate(0.200073 0.799805)"/>
                </clipPath>
                </defs>
                </svg>
                <h6>تصفية المشاريع</h6>
            </div>

            <form action="">
                <div class="row">
    
                    <div class="col-md-6 col-lg-3 d-none">
                        <div class="box search">
                            <div class="labal">
                                <label for="search">البحث</label>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <div class="input_group">
                                <input value="{{ request("search") }}" type="text" name="search" id="search" placeholder="البحث في المشاريع...">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="box location">
                            <div class="labal">
                                <label for="location">الموقع</label>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.0434 7.46663C14.0434 11.4666 8.71004 15.4666 8.71004 15.4666C8.71004 15.4666 3.37671 11.4666 3.37671 7.46663C3.37671 6.05215 3.93861 4.69559 4.93881 3.6954C5.939 2.6952 7.29555 2.1333 8.71004 2.1333C10.1245 2.1333 11.4811 2.6952 12.4813 3.6954C13.4815 4.69559 14.0434 6.05215 14.0434 7.46663Z" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.71002 9.46631C9.81459 9.46631 10.71 8.57088 10.71 7.46631C10.71 6.36174 9.81459 5.46631 8.71002 5.46631C7.60545 5.46631 6.71002 6.36174 6.71002 7.46631C6.71002 8.57088 7.60545 9.46631 8.71002 9.46631Z" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="input_group">
                                <select name="city" id="location">
                                    <option value=""></option>
                               @foreach ($cities as $item)
                                    <option @selected(request('city') == $item->id) value="{{ $item->id }}">{{ $item->name}}</option>
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="box budget">
                            <div class="labal">
                                <label for="budget">نطاق الميزانية</label>
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                            <div class="input_group">
                                <select name="budget" id="budget">
                                    <option value=""></option>

                                      @foreach ($budgets as $item)
                                    <option @selected(request('budget') == $item) value="{{ $item }}">{{ $item }}</option>
                                        
                                    @endforeach
                             
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="box specialization">
                            <div class="labal">
                                <label for="specialization">التخصص</label>
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.98067 2.52397C8.73068 2.2739 8.3916 2.13338 8.03801 2.1333H3.25667C2.90305 2.1333 2.56391 2.27378 2.31386 2.52383C2.06382 2.77387 1.92334 3.11301 1.92334 3.46663V8.24797C1.92342 8.60156 2.06394 8.94064 2.31401 9.19063L8.11667 14.9933C8.41968 15.2944 8.8295 15.4634 9.25667 15.4634C9.68384 15.4634 10.0937 15.2944 10.3967 14.9933L14.7833 10.6066C15.0844 10.3036 15.2534 9.8938 15.2534 9.46663C15.2534 9.03947 15.0844 8.62964 14.7833 8.32663L8.98067 2.52397Z" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.58999 6.13298C5.77408 6.13298 5.92332 5.98374 5.92332 5.79964C5.92332 5.61555 5.77408 5.46631 5.58999 5.46631C5.40589 5.46631 5.25665 5.61555 5.25665 5.79964C5.25665 5.98374 5.40589 6.13298 5.58999 6.13298Z" fill="#374151" stroke="#374151" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="input_group">
                                <select name="speciality" id="specialization">
                                    <option value=""></option>

                                    @foreach ($specialites as $item)
                                    <option @selected(request('speciality') == $item->id) value="{{ $item->id }}">{{ $item->name }}</option>
                                        
                                    @endforeach
                                  
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bottom">
                    <button type="submit" class="main_btn_bg">تطبيق المرشحات</button>
                    <a href="{{ route('provider.project.index') }}" class="delete">مسح الكل</a>
                </div>
            </form>


        </div>


         <div class="projects">
                <div class="row">
                     @foreach($projects as $project)
        <div class="col-md-6 col-lg-4">

                @include('provider.components.project-card', ['project' => $project])
        </div>

            @endforeach
                </div>
        </div>


    </div>





    @endsection
 
  

