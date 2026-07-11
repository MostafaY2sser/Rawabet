@extends('customer.layouts.main')
@section('title','لوحة التحكم - العميل')


@section('content')

    <div class="content_user_board " id="main_page">


        <div class="head ">
            <div class="text">
                <h3>لوحه التحكم</h3>
                <p>يمكنك تتبع المقاييس الرئيسية وقياسها وتحسينها لتعزيز رضا العملاء ودفع النمو.</p>
            </div>


           <div class="dropdown-container">
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




        <div class="projects_info">
            <div class="box">
                <h6>إجمالي المشاريع</h6>
                <div class="date">
                    <span>{{ $allProjects }}</span>
                    <p>منذ الشهر الماضي</p>
                </div>
                {{-- <div class="dot">...</div> --}}
            </div>

            <div class="box">
                <h6>المشاريع المكتملة</h6>
                <div class="date">
                    <span>{{ $completedProjects }}</span>
                    <p>منذ الشهر الماضي</p>
                </div>
                {{-- <div class="dot">...</div> --}}
            </div>

            <div class="box">
                <h6>المشاريع قيد التنفيذ</h6>
                <div class="date">
                    <span>{{ $inProgressProjects }}</span>
                    <p>منذ الشهر الماضي</p>
                </div>
                {{-- <div class="dot">...</div> --}}
            </div>

            <div class="box">
                <h6>المشاريع الملغاة</h6>
                <div class="date">
                    <span>{{ $cancelledProjects }}</span>
                    <p>منذ الشهر الماضي</p>
                </div>
                {{-- <div class="dot">...</div> --}}
            </div>
        </div>



        <div class="user_projects">

            <div class="head">
                <div class="projects_number">
                    <h5>مشاريعي <span>({{ $projects->count() }})</span></h5>
                    <p>قائمة بجميع مشاريعك وحالة التنفيذ الحالية</p>
                </div>

                <!-- Search and filter -->
                <form action="{{ route('customer.dashboard') }}" method="GET" class="d-flex gap-3">

                    <!-- Search -->
                    <div class="input_group">
                        <div class="icon">
                            <i class="fa-solid fa-magnifying-glass " ></i>
                        </div>
                        <input type="search" name="project_search" id="project_search"
                            placeholder="البحث في المشاريع والعروض.." value="{{ request('project_search') }}">
                    </div>

                    <!-- filter -->
                    <div class="input_group">
                        <select name="project_filter" id="project_filter" onchange="this.form.submit()">
                            <option value="all" @selected(request('project_filter') == 'all')>الكل</option>
                            @foreach (\App\Enums\ProjectStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected(request('project_filter') == $status->value)>
                                    {{ \App\Enums\ProjectStatus::getLabel($status->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </form>
            </div>


            @if($projects->isEmpty())
                <div class="no_projects">
                    <h5>لا يوجد مشاريع حالية, ابدأ مشروعًا جديدًا</h5>
                    <p>نوفر لك أفضل المقاولين المعتمدين في المملكة العربية السعودية، مع ضمان أعلى معايير الجودة <br> والشفافية
                        في كل خطوة من مراحل التنفيذ.</p>
                    <a href="{{ route('customer.project.create') }}" class="add_project_btn main_btn_bg">
                        <span>ابدأ مشروعك الآن</span>
                        <i class="fa-solid fa-plus"></i>
                    </a>
                    <div class="image">
                        <svg width="150" height="100" viewBox="0 0 150 100" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="150" height="100" fill="url(#pattern0_2116_24377)"/>
                        <defs>
                        <pattern id="pattern0_2116_24377" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_2116_24377" transform="scale(0.00666667 0.01)"/>
                        </pattern>
                        <image id="image0_2116_24377" width="150" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                        </defs>
                        </svg>
                    </div>
                </div>
            @else
                <div class="projects">
                    <div class="row">
                        @foreach ($projects as $project)
                            <div class="col-md-6 col-lg-4">
                                @include('customer.components.project-card', ['project' => $project])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif



        </div>









        <!-- End content_user_board  -->
    </div>




@endsection


