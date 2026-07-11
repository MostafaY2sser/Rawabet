@extends('customer.layouts.main')
@section('title', 'مشاريعي')

@section('content')
    <div class="content_user_board"  id="main_page">
        <div class="user_projects">

            <div class="head">
                <div class="projects_number">
                    <h5>مشاريعي <span>({{ count($projects) }})</span> </h5>
                    <p>قائمة بجميع مشاريعك وحالة التنفيذ الحالية</p>
                </div>

                <!-- Search and filter -->
                <form action="" method="GET" class="d-flex gap-3">
                    <!-- Search  -->
                    <div class="input_group">
                        <div class="icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                        <input type="search" value="{{ request()->get('project_search') }}" name="project_search" id="project_search"
                            placeholder="البحث في المشاريع والعروض...">
                    </div>

                    <!-- filter -->
                    <div class="input_group">
                        <select name="project_filter" id="project_filter" onchange="this.form.submit()">
                            <option value="all">الكل</option>
                            @foreach (\App\Enums\ProjectStatus::cases() as $status)
                                <option @selected(request('project_filter') == $status->value) value="{{ $status->value }}">
                                    {{ \App\Enums\ProjectStatus::getLabel($status->value) }}</option>
                            @endforeach
                        </select>

                    </div>

                </form>
            </div>


            @if ($projects->isEmpty())
                <div class="no_projects">
                    <h5>لا يوجد مشاريع حالية, ابدأ مشروعًا جديدًا</h5>
                    <p>نوفر لك أفضل المقاولين المعتمدين في المملكة العربية السعودية، مع ضمان أعلى معايير الجودة <br>
                        والشفافية
                        في كل
                        خطوة من مراحل التنفيذ.</p>
                    <a href="{{ route('customer.project.create') }}" class="add_project_btn main_btn_bg">
                        <span>ابدأ مشروعك الآن</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.9987 3.33203V12.6654M3.33203 7.9987H12.6654" stroke="#F5932E" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            @else
        </div>






        <div class="projects ">
            <div class="row">

                @foreach ($projects as $project)
                    <div class="col-md-6 col-lg-4">
                        @include('customer.components.project-card', ['project' => $project])
                    </div>
                @endforeach

            </div>
        </div>
        @endif


        <!-- End content_user_board  -->
    </div>

@endsection
