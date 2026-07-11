@extends('provider.layouts.main')
@section('title','لوحة التحكم - المزود')


@section('content')
    <div class="dashboard " id="main_page">

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
                        <span id="selectedText">
                        
                    @if($period === 'month')
                        هذا الشهر
                    @elseif($period === 'week')
                        هذا الاسبوع
                    @elseif($period === 'day')
                        هذا اليوم
                    @endif
                </span>
                        
                    </div>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('provider.dashboard', ['period' => 'month']) }}" class="dropdown-item {{ $period == 'month' ? 'selected' : '' }}">هذا الشهر</a>
                    <a href="{{ route('provider.dashboard', ['period' => 'week']) }}" class="dropdown-item {{ $period == 'week' ? 'selected' : '' }}">هذا الاسبوع</a>
                    <a href="{{ route('provider.dashboard', ['period' => 'day']) }}" class="dropdown-item {{ $period == 'day' ? 'selected' : '' }}">هذا اليوم</a>
                </div>
            </div>

        </div>


        <div class="projets_information">

            <div class="projects_status">
                <div class="row">
                    @foreach($stats as $stat)
                        <div class="col-md-6 col-lg-3">
                            <div class="box">
                                <h6 class="title">{{ $stat['title'] }}</h6>
                                <div class="numbers">
                                    <div class="right">
                                        <span>{{ $stat['count'] }}</span>
                                        <p>منذ الشهر الماضي</p>
                                    </div>
                                    <div class="left">
                                        <span>{{ $stat['percent'] }}</span>
                                        <i class="fa-solid fa-chart-line"></i>
                                    </div>
                                </div>
                                {{-- <div class="dot">...</div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="dashboard-card">
                <!-- Header -->
               
                <div class="header">
                    <div class="title-section">
                        <h1 class="main-title">نظرة عامة على المشاريع</h1>
                        <p class="subtitle">تتبع المقاييس الرئيسية وقياسها وتحسينها</p>
                    </div>

                    <!-- Navigation Tabs -->
                  
                    <div class="tabs-container d-flex align-items-center gap-2">
                        <div class="tabs">
                            <button class="tab-button active" data-period="monthly">شهرياً</button>
                            <button class="tab-button" data-period="weekly">أسبوعياً</button>
                            <button class="tab-button d-none" id="daily-btn" data-period="daily">يومياً</button>
                        </div>

                        <div class="dot" id="dot-toggle">
                            <span>...</span>
                        </div>
                    </div>
                </div>

                <!-- Chart Container -->
               
                <div class="chart-container">
                    <canvas id="projectChart" data-month='@json($chartDataMonthly)' data-week='@json($chartDataWeekly)' data-day='@json($chartDataDaily)'></canvas>
                </div>

            </div>
        </div>




        <section class="payments">
            <div class="bills ">
              
                <div class="head">
                    <div class="text">
                        <h6>المشاريع النشطة</h6>
                        <span>إدارة مشاريعك بكفاءة </span>
                    </div>
                    <form action="{{ route('provider.dashboard') }}" method="GET">
                        <div class="input_group">
                            <input type="search" 
                                name="search" 
                                id="search" 
                                value="{{ request('search') }}" 
                                placeholder="البحث">
                            <i class="fa-solid fa-magnifying-glass search_icon"></i>
                        </div>

                        <div class="input_group">
                            <select name="filter" id="filter" onchange="this.form.submit()">
                                <option value="">الكل</option>
                                @foreach(\App\Enums\ProjectStatus::cases() as $status)
                                    <option value="{{ $status->value }}"
                                        {{ request('filter') == $status->value ? 'selected' : '' }}>
                                        {{ \App\Enums\ProjectStatus::getLabel($status->value) }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </form>

                </div>
                <table>
                    <thead>
                        </tr>
                        <th>المشروع</th>
                        <th>العميل </th>
                        <th>قيمة العقد </th>
                        <th>نسبة التقدم </th>
                        <th> الحالة </th>
                        <th>المرحلة الحالية </th>
                        <tr>
                    </thead>

                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td class="head_row">
                                    <h6>{{ $project->serviceType->name }} {{ $project->buildingType->name }}</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-regular fa-calendar"></i>
                                        @php
                                            $start = \Carbon\Carbon::parse($project->start_date);
                                            $end = $project->duration ? $start->copy()->addMonths($project->duration) : $start;
                                        @endphp

                                        <p>{{ $start->translatedFormat('j F Y') }} - {{ $end->translatedFormat('j F Y') }}</p>

                                    </div>
                                </td>
                                <td class="customer">
                                    <i class="fa-regular fa-user"></i>
                                    <p>{{ $project->customer->full_name}}</p>
                                </td>
                                <td>{{ number_format($project->budget) }} ر.س</td>


                                <td class="prog">
                                    @php
                                        $totalProgress  =$project->overAllProgress();
                                    @endphp
                                    <progress value="{{ $totalProgress}}" max="100"></progress>
                                    <small>{{ round($totalProgress) }}%</small>
                                </td>

                                <td>
                                                                        @switch($project->status)
                                        @case(\App\Enums\ProjectStatus::COMPLETED->value)
                                            <span class="complete">
                                                <i class="fa-regular fa-circle-check"></i>
                                                مكتمل
                                            </span>
                                            @break

                                        @case(\App\Enums\ProjectStatus::IN_PROGRESS->value)
                                            <span class="in-progress">
                                                <i class="fa-regular fa-hourglass-half"></i>
                                                جاري التنفيذ
                                            </span>
                                            @break

                                        @case(\App\Enums\ProjectStatus::PENDING->value)
                                            <span class="pending">
                                                <i class="fa-regular fa-clock"></i>
                                                قيد المراجعة
                                            </span>
                                            @break

                                        @case(\App\Enums\ProjectStatus::CANCELLED->value)
                                            <span class="cancelled">
                                                <i class="fa-regular fa-circle-xmark"></i>
                                                ملغي
                                            </span>
                                            @break

                                        @default
                                            <span class="unknown">غير معروف</span>
                                    @endswitch

                                </td>
                                <td class="task">
        <p>{{ $project->work_description }}</p>
    </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </section>



    </div>
    
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Charts -->
    <script src="{{asset('assets\js\provider\chart.js')}}"></script>
        
    
@endpush

