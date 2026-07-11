@extends('provider.layouts.main')

@section('title')
    تنفيذ المشاريع
@endsection

@php

    $depositemItem = $offer->deposite();
    $depositeAmount =  $offer->deposite()->amount;
    $PaymentSchedule = $offer->paymentSchedules;

    use Carbon\Carbon;
    Carbon::setLocale('ar');
    $date = Carbon::now();

    $activeStage = $stagesInfo['activeStage'];
   
    
  
@endphp



@section('content')
    <div class="offer_details project_details provider" id="main_page">
        <div class="project_info">
            <div class="head">
                {{-- provider/project/in-progress --}}
                <a href="{{ route('provider.project.in.progress') }}" class="back">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للمشاريع</span>
                </a>
            </div>

            <div class="categors">
                @php
                    $statusLabel = \App\Enums\OfferStatus::getLabel($offer->status);
                    $statusIcon = \App\Enums\OfferStatus::getIcon($offer->status);
                    $statusShort = \App\Enums\OfferStatus::shortStatus($offer->status);
                @endphp

                <div class="status {{ $statusLabel }}">
                    <span>{{ $statusShort }}</span>
                    <i class="{{ $statusIcon }}"></i>
                </div>

            </div>

            <h2 class="project_name">
                {{ $offer->project->serviceType->name }} {{ $offer->project->buildingType->name }}
            </h2>

            <div class="about">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="box one mb-3 mb-md-0">
                            <div>
                                <i class="fa-solid fa-chart-column"></i>
                                <p>التقدم العام</p>
                            </div>
                            <span>{{ $stagesInfo['overallProgress'] }}%</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="box two mb-3 mb-md-0">
                            <div>
                                <i class="fa-regular fa-clock"></i>
                                <p>المراحل المكتملة</p>
                            </div>
                            <span>{{ count($offer->items) }}/ {{ $stagesInfo['finishedStages']  }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="box three mb-3 mb-md-0">
                            <div>
                                <i class="fa-regular fa-calendar"></i>
                                <p>تاريخ البدء</p>
                            </div>
                            <span class="date">{{ $offer->start_date }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="box four mb-3 mb-md-0">
                            <div>
                                <i class="fa-regular fa-calendar"></i>
                                <p>تاريخ الانتهاء المتوقع</p>
                            </div>
                            <span class="date">{{ $offer->expected_end_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="about_project">

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="project_phases" class="active">
                        <i class="fa-regular fa-file"></i>
                        <span>مراحل المشروع</span>
                    </li>


                    <li data-target="paymentSchedule">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span>جدول الدفعات</span>
                    </li>
                    <li data-target="timeline">
                        <i class="fa-regular fa-calendar"></i>
                        <span>الجدول الزمني</span>
                    </li>
                    <li data-target="documents">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>المستندات</span>
                    </li>
                </ul>
            </div>

            <div class="contents">
                <div class="content_tap project_phases  ">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="phases">
                                <h6>مراحل المشروع</h6>
                                @foreach ($offer->items as $key => $item)
                                    <div class="phase">
                                        <div class="head">
                                            <span
                                                class="status {{ $item->status }}">{{ App\Enums\OfferItemStatus::getLabel($item->status) }}</span>
                                            <div>
                                                المرحلة
                                                <span>{{ $key + 1 }}</span>
                                                @if ($item->status == App\Enums\OfferItemStatus::ACTIVE->value)
                                                    <i class="fa-solid fa-play"></i>
                                                @elseif($item->status == App\Enums\OfferItemStatus::PENDING->value)
                                                    <i class="fa-regular fa-clock"></i>
                                                @endif

                                            </div>
                                        </div>
                                        <h5>{{ $item->title }}</h5>
                                        <div class="prog">
                                            <span>{{ $item->progress }}%</span>
                                            <progress value="{{ $item->progress }}" max="100"></progress>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <div class="data">
                                <div class="head">
                                    <h4>{{ $activeStage->title }}</h4>
                                    @if (
                                        $item->status == App\Enums\OfferItemStatus::ACTIVE->value ||
                                            $item->status == App\Enums\OfferItemStatus::PENDING->value)
                                        <div class="buttons">
                                            <a href="{{ route('provider.project.implementation.update.progress', $activeStage->id) }}"
                                                class="main_btn_bg">تحديث التقدم</a>
                                            {{-- <a href="#" class="main_btn_bg order">طلب معاينة</a> --}}
                                        </div>
                                    @endif
                                </div>
                                <div class="current_progress my-3">
                                    <p>نسبة الإنجاز الحالية</p>
                                    <span>{{ $activeStage->progress }}%</span>
                                </div>
                                <div class="phase_description my-2">
                                    <p>وصف المرحلة</p>
                                    <span>{{ $activeStage->description }}</span>
                                </div>
                                <div class="row my-4">
                                    <div class="col-6">
                                        <div class="data_box">
                                            <p>تاريخ البدء</p>
                                            <span>{{ $activeStage->start_date }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="data_box">
                                            <p>تاريخ الانتهاء</p>
                                            <span>{{ $activeStage->excpcted_end_date }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="phase_notes">
                                    <p>ملاحظات المرحلة</p>
                                    <span>{{ $activeStage->comments }}</span>
                                </div>
                                <div class="phase_images my-4">
                                    <h6>صور المرحلة</h6>
                                    <div class="row">

                                        @foreach ($activeStage->attachments as $item)
                                            <div class="col-6 col-md-4 ">
                                                <div class="image">
                                                    <img src="{{ Storage::url($item->file_path) }}" width="200"
                                                        height="200" alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($item->status == App\Enums\OfferItemStatus::ACTIVE->value)
                                    <div class="buttons">
                                        <a href="{{ route('provider.project.implementation.update.progress', $activeStage->id) }}"
                                            class="main_btn_bg">تحديث التقدم</a>
                                        {{-- <a href="#" class="main_btn_bg order">طلب معاينة</a> --}}
                                        {{-- <a href="#" class="main_btn_bg report">تقرير المرحلة</a> --}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>




                <div class="content_tap paymentSchedule d-none">
                    <h6>جدول الدفعات:</h6>
                    <ul>
                        @if ($PaymentSchedule)
                            @foreach ($PaymentSchedule as $index => $item)
                                <li>
                                    <span class="num">{{ $index + 1 }}</span>
                                    <div class="text">
                                        <p>{{ $item->title }}</p>
                                        <span>{{ $item->percentage }}% من إجمالي العقد</span>
                                    </div>
                                    <span
                                        class="value">{{ number_format(($offer->total_amount * $item->percentage) / 100, 2) }}
                                        ر.س.</span>
                                </li>
                            @endforeach
                        @else
                            <li>لا توجد دفعات مقترحة.</li>
                        @endif
                    </ul>

                    <div class="total">
                        <div class="text">
                            <span>إجمالي قيمة المشروع</span>
                            <p>شامل جميع الدفعات</p>
                        </div>
                        <div class="values">
                            <span>{{ number_format($offer->total_amount) }}</span>
                            <p>ريال سعودي</p>
                        </div>
                    </div>
                </div>


                <div class="content_tap timeline d-none">
                    <div class="row">

                        <div class="col-md-6 col-lg-4">
                            <div class="box">
                                <i class="fa-regular fa-calendar"></i>
                                <span>
                                    {{ $offer->items->isNotEmpty() ? Carbon::parse($offer->items->first()->start_date)->translatedFormat('j F Y') : '-' }}
                                </span>
                                <p>تاريخ البدء</p>
                            </div>

                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="box">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ Carbon::parse($offer->expected_end_date)->translatedFormat('j F Y') }}</span>
                                <p>تاريخ الانتهاء المتوقع</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="box">
                                <i class="fa-regular fa-calendar"></i>
<span>
    {{ \Carbon\Carbon::parse($offer->start_date)->diffInDays(\Carbon\Carbon::parse($offer->end_date)) }} يوم
</span>
                                <p>المدة الكلية</p>
                            </div>
                        </div>
                    </div>

                    <h6 class="mt-5">المعالم الزمنية:</h6>
                    <ul>
                        @foreach ($offer->items as $index => $item)
                            <li>
                                <span class="num">{{ $index + 1 }}</span>
                                <div class="text">
                                    <p>{{ $item->title }}</p>
                                    <div>
                                        <span>المدة المتوقعة: </span>
                                        <span>{{ $item->total_days }} يوم</span>
                                    </div>
                                </div>
                                <span class="value">
                                    {{ Carbon::parse($item->start_date)->translatedFormat('j F Y') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>



                <div class="content_tap documents d-none">
                    <div class="row">
                        @foreach ($attachments as $key => $list)
                            @foreach ($list as $file)
                                <div class="col-md-6">
                                    <div class="card_content">
                                        <div class="file_info">
                                            <i class="fas fa-file-pdf icon-pdf fa-lg"></i>
                                            <div class="file_details">
                                                <p>{{ $key }}</p>
                                            </div>
                                        </div>
                                        <div class="file_actions">
                                            
                                            <a class="main_btn_bg preview" href="{{ route('provider.project.download.file' , $file->id) }}"
                                                >
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>


            </div>




        </div>



    </div>
@endsection
@push('scripts')
    <script>
        // Swetch taps and Sections :----
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll("#menu-tabs li");
            const sections = document.querySelectorAll(".content_tap");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {

                    // Remove active class from all taps :-
                    tabs.forEach(t => t.classList.remove("active"));

                    // Add class Active for current tap :- 
                    this.classList.add("active");

                    // Hidden all Sections
                    sections.forEach(sec => sec.classList.add("d-none"));

                    // Show target Section :-
                    const targetClass = this.getAttribute("data-target");
                    const targetSection = document.querySelector(`.content_tap.${targetClass}`);
                    if (targetSection) {
                        targetSection.classList.remove("d-none");
                    }
                });
            });

            // Show Frist Section :-
            document.querySelector(".content_tap.offerDetails").classList.remove("d-none");
        });
    </script>
@endpush
