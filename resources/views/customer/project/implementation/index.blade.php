@extends('customer.layouts.main')

@section('title')
    تنفيذ المشاريع
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        #main_page .financial_terms .value.payment-line-totals {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            min-width: 150px;
            text-align: end;
        }

        #main_page .financial_terms .value.payment-line-totals .payment-line-amount {
            color: #111827;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
        }

        #main_page .financial_terms .value.payment-line-totals .payment-line-tax,
        #main_page .financial_terms .value.payment-line-totals .payment-line-total {
            margin: 0;
            background: none;
            border: none;
            border-radius: 0;
            padding: 0;
            font-size: 12px;
            font-weight: 500;
            color: #6B7280;
            line-height: 1.4;
            width: auto;
            display: block;
        }

        #main_page .financial_terms .value.payment-line-totals .payment-line-total {
            font-weight: 600;
            color: #3C3F47;
        }

        #main_page .financial_terms .value.payment-line-totals p.paid {
            background-color: #DCFCE7;
            border: 1px solid #BBF7D0;
            border-radius: 30px;
            padding: 3px 10px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 4px;
        }

        #main_page .project_phases .item .box .text .stage-tax-note {
            margin: 4px 0 0;
            font-size: 12px;
            font-weight: 500;
            color: #6B7280;
            line-height: 1.4;
        }

        @media (max-width: 767px) {
            #main_page .financial_terms .value.payment-line-totals .payment-line-tax,
            #main_page .financial_terms .value.payment-line-totals .payment-line-total,
            #main_page .financial_terms .value.payment-line-totals p.paid {
                font-size: 10px !important;
            }

            #main_page .financial_terms .value.payment-line-totals .payment-line-amount {
                font-size: 12px !important;
            }

            #main_page .project_phases .item .box .text .stage-tax-note {
                font-size: 10px !important;
            }
        }
    </style>
@endpush
@php

    use Carbon\Carbon;

    $depositemItemAmount = $details['deposite_amount'];
    $contractSubtotal = $details['total_amount_with_extra'];
    $contractTaxAmount = $details['tax_amount'];
    $taxPercentage = $details['tax_percentage'];
    $contractTotalWithTax = $details['total_amount_with_tax'];
    $depositePaidAmount = $details['deposite_amount_with_tax'];
    $outstandingWithTax = $details['outstanding_with_tax'];
    $selectedServices = $offer->additionalServices()->where('selected', 1)->get();
    $provider = $offer->provider;
    $PaymentSchedule = $offer->paymentSchedules;

    Carbon::setLocale('ar');
    $date = Carbon::now();

    $totalProgress = $offer->itemsWithSelectedServices()->sum('progress');
    $itemCount = $offer->itemsWithSelectedServices()->count();

    $overallProgress = $itemCount > 0 ? round($totalProgress / $itemCount, 2) : 0;

    $canRequestInspection = $project->inspections()->where('status', 'pending')->count() == 0 ? true : false;

@endphp



@section('content')
    <div class="project_details approval_details" id="main_page">

        <div class="project_info">
            <div class="head">
                <a href="{{ route('customer.project.index') }}">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للمشاريع</span>
                </a>
                <div class="buttons">

                    <a href="{{ route('customer.project.implementation.request.change', $project->id) }}"
                        class="main_btn_bg different d-none" >
                        <span>طلب تغير</span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    @if ($canRate)
                        <a href="{{ route('customer.rate.create', $project->id) }}" class="main_btn_bg different">
                            <span>تقييم المقاول</span>
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                    @endif
                    {{-- @if ($canRequestInspection)
                        <button class="main_btn_bg  update request_inspection_btn ">
                            <span>طلب معاينة المشرف الهندسي</span>
                        </button>
                    @endif --}}
                </div>
            </div>

            <div class="categors">
                <div class="status">
                    <span>{{ App\Enums\ProjectStatus::getLabel($project->status) }}</span>
                </div>
                <div>
                    <img src="/assets/images/customer/icons/tag-01.png" alt="">
                    <span>{{ $project->category->name }}</span>
                </div>
                <div>
                    <img src="/assets/images/customer/icons/tag-01.png" alt="">
                    <span>{{ $project->projectType->name }}</span>
                </div>
            </div>

            <h2 class="project_name">{{ $project->serviceType->name }} {{ $project->buildingType->name }}</h2>

            <div class="info">
                <div>
            <span>
    {{ $offer->total_days }} يوم
</span>

<p>مدة الانتهاء المتوقعة:</p>

                    <img src="/assets/images/customer/icons/culander.png" alt="">
                </div>
                <div>
                    <span>{{ $project->region->name }}</span>
                    <img src="/assets/images/customer/icons/location.png" alt="">
                </div>
                <div>
                    <p>ريال</p>
                    <span>{{ number_format($contractTotalWithTax, 2) }}</span>
                    <img src="/assets/images/customer/icons/budget.png" alt="">
                </div>
                <div>
                    <span>اسم المقاول</span>
                    <p>{{ $provider?->company_name ?? '—' }}</p>
                    <img src="/assets/images/customer/icons/globe.png" alt="">
                </div>
            </div>



        </div>


        <div class="container_progress">
            <h6>نسبة الإنجاز الحالية</h6>
            <div class="progress_box">
                <span>{{ $overallProgress }}%</span>
                <progress value="{{ $overallProgress }}" max="100"></progress>
            </div>
        </div>




        <div class="about_project">

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="overview">
                        <i class="fa-regular fa-eye"></i>
                        <span>نظرة عامة</span>
                    </li>
                    <li data-target="project_phases">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>مراحل المشروع</span>
                    </li>
                    <li data-target="contractor">
                        <i class="fa-solid fa-globe"></i>
                        <span>المقاول</span>
                    </li>
                    <li data-target="payment_schedule">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span>جدول الدفعات</span>
                    </li>
                    <li data-target="timeline">
                        <i class="fa-regular fa-calendar"></i>
                        <span>الجدول الزمني</span>
                    </li>
                    <li data-target="reports">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>التقارير</span>
                    </li>
                </ul>
            </div>



            <div class="contents">

                <div class="section_tap overview ">
                    <div class="project_desc">
                        <h6>وصف المشروع</h6>
                        <p>{{ $project->work_description }}</p>
                    </div>
                    <div class="info">
                        <div class="row w-100">
                            <div class="col-6">
                                <div class=" box location">
                                    <div>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>الموقع</span>
                                    </div>
                                    <h6>{{ $project->city->name }} - {{ $project->region->name }}</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box type">
                                    <div>
                                        <i class="fa-regular fa-building"></i>
                                        <span>نوع المشروع</span>
                                    </div>
                                    <h6>{{ $project->projectType->name }}</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box dateline">
                                    <div>
                                        <i class="fa-regular fa-clock"></i>
                                        <span>مدة التنفيذ المتوقعة</span>
                                    </div>
<h6>
    {{ $offer->total_days }} يوم
</h6>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="box budget">
                                    <div>
                                        <i class="fa-solid fa-dollar-sign"></i>
                                        <span>الميزانية المتوقعة</span>
                                    </div>
                                    <h6>{{ number_format($contractTotalWithTax, 2) }} ريال</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="section_tap project_phases ">
                    <h5 class="taps_title">مراحل المشروع</h5>

                    @foreach ($offer->itemsWithSelectedServices as $item)
                        <div class="phase">
                            <span class="status complete">{{ App\Enums\OfferItemStatus::getLabel($item->status) }}</span>
                            <h6 class="name_phase">{{ $item->title }}</h6>
                            <div class="progress_box">
                                <span>{{ $item->progress }}%</span>
                                <progress value="{{ $item->progress }}" max="100"></progress>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="title_row">
                                            <span>الوصف</span>
                                            <p>{{ $item->description }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="box">
                                            <span class="icon"><i class="fa-regular fa-calendar"></i></span>
                                            <div class="text">
                                                <span>تاريخ البدء</span>
                                                <h4>{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="box">
                                            <span class="icon"><i class="fa-regular fa-clock"></i></span>
                                            <div class="text">
                                                <span>تاريخ الانتهاء</span>
                                                <h4>{{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="box">
                                            <span class="icon"><i class="fa-solid fa-dollar-sign"></i></span>
                                            <div class="text">
                                                <span>قيمة الدفعة</span>
                                                @php
                                                    $stageAmount = $item->paymentSchedule?->amount ?? $item->amount;
                                                    $stageTaxAmount = getTaxAmount($stageAmount, $taxPercentage);
                                                @endphp
                                                <h4>
                                                    {{ number_format($stageAmount + $stageTaxAmount, 2, '.', ',') }}
                                                    ر.س
                                                </h4>
                                                <p class="stage-tax-note">الضريبة: {{ number_format($stageTaxAmount, 2, '.', ',') }} ر.س.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="technical">
                                    <span>المواصفات الفنية</span>
                                    <p> {{ $item->specifications }}</p>
                                </div>
                            </div>
                            @if (
                                $item->status == \App\Enums\OfferItemStatus::COMPLETED->value ||
                                    $item->status == \App\Enums\OfferItemStatus::REQUESTPAYMENT->value)
                                @if (!$item->inspection || $item->inspection?->status != 'pending')
                                    <div class="request_inspection" id="StageInspection{{ $item->id }}">
                                        <div class="wrapper">
                                            <h6>تحديد موعد المعاينة</h6>
                                            <form
                                                action="{{ route('customer.project.implementation.request.inspection', $project->id) }}"
                                                method="POST">
                                                <div class="new_date">
                                                    @csrf
                                                    <label for="inlineCalendar">اختر التاريخ الجديد</label>
                                                    <input type="text" name="new_date" id="inlineCalendar" hidden>
                                                </div>
                                                <div class="input_group">
                                                    <label for="time">اختر الوقت</label>
                                                    <input type="time" name="time" id="time">
                                                    <input type="hidden" value="{{ $item->id }}" name="stage_id">
                                                </div>
                                                {{-- <p class="note">ملاحظة: يمكن تغيير الموعد مرة واحدة فقط، ويجب أن يكون قبل
                                                الموعد المحدد بـ 24
                                                ساعة على الأقل.</p> --}}
                                                <div class="buttons mt-4">
                                                    <button class="main_btn_bg">تأكيد التغيير</button>
                                                    <button class="main_btn_bg cancel">إلغاء</button>
                                                </div>
                                            </form>
                                            <div class="close_request_inspection">
                                                <i class="fa-solid fa-x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_inBox">
                                        @if (!$item->inspection || $item->inspection?->status == 'cancelled' )
                                            <a href="#" class="main_btn_bg order"
                                                onclick="TogglePopUp('StageInspection{{ $item->id }}')">طلب معاينة</a>
                                        @endif
                                        {{-- <button class="main_btn_bg green "><i class="fa-regular fa-file-lines"></i></button> --}}
                                        @if ($item->inspection && $item->inspection?->status != 'pending')
                                            <a href="{{ route('customer.inspection.show', $item->inspection?->id) }}"
                                                class="main_btn_bg  green report ">
                                                <i class="fa-regular fa-file-lines"></i>
                                                <span>عرض تقرير المعاينة</span>
                                            </a>
                                        @endif

                                        @if ($item->status == \App\Enums\OfferItemStatus::REQUESTPAYMENT->value)
                                            <a href="/myfatoorah?st-id={{ $item->id }}&of-id={{ $offer->id }}"
                                                class="main_btn_bg  green report ">
                                                <i class="fa-regular fa-file-lines"></i>
                                                <span>الموافقة على صرف الدفعة المرحلية</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach

                </div>


                <div class="section_tap contractor">
                    <h5 class="taps_title">المقاول</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info">
                                <div class="box">
                                    <p>اسم الشركة</p>
                                    <span>{{ $provider?->company_name ?? '—' }}</span>
                                </div>
                                <div class="box">
                                    <p>التقييم</p>
                                    <div class="rating">
                                        <span>{{ number_format($averageRate, 1) ?? 0 }}</span>
                                        <div class="rate">
                                            @for ($i = 1; $i <= $averageRate; $i++) 
                                                                                           <img src="/assets/images/home/star.png" alt="">

                                                @endfor
                                 
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <p>رقم الهاتف</p>
                                    <span>{{ $provider?->phone_number ?? '—' }}</span>
                                </div>
                                <div class="box">
                                    <p>البريد الإلكتروني</p>
                                    <span>{{ $provider?->email ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact d-none">
                                <a href="#" class="main_btn_bg">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>التواصل مع المقاول</span>
                                </a>
                                <a href="#" class="main_btn_bg">
                                    <i class="fa-regular fa-star"></i>
                                    <span>تقييم المقاول</span>
                                </a>
                                <a href="#" class="main_btn_bg">
                                    <i class="fa-regular fa-eye"></i>
                                    <span>عرض الملف التعريفي</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="section_tap payment_schedule ">
                    <div class="financial_terms  my-3">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 ">
                                <div class="box  mb-3 mb-md-0">
                                    <h4>{{ number_format($outstandingWithTax, 2, '.', ',') }} ر.س.</h4>
                                    <span>المبلغ المتبقي</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="box  mb-3 mb-md-0">
                                    <h4>{{ number_format($depositePaidAmount, 2, '.', ',') }} ر.س.</h4>
                                    <span>العربون المدفوع</span>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="box  mb-3 mb-md-0">
                                    <h4>{{ number_format($contractTotalWithTax, 2, '.', ',') }} ر.س.</h4>
                                    <span>إجمالي قيمة العقد</span>
                                </div>
                            </div>
                        </div>
                        <h6 class="sub_title mt-3 mt-md-5">جدول الدفعات:</h6>
                        <ul>
                            @foreach ($offer->paymentSchedules as $key => $item)
                                <li>
                                    <span class="num {{ $item->status == 'paid' ? 'paid' : '' }}">{{ $key + 1 }}</span>
                                    <div class="text">
                                        <p>{{ $item->title }}</p>
                                        <div>
                                            @if ($item->percentage > 0)
                                                <span>{{ $item->percentage }}% من إجمالي العقد</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="value payment-line-totals">
                                        <span class="payment-line-amount">{{ number_format($item->amount, 2, '.', ',') }} ر.س.</span>
                                        <p class="payment-line-tax">الضريبة: {{ number_format(getTaxAmount($item->amount, $taxPercentage), 2, '.', ',') }} ر.س.</p>
                                        <p class="payment-line-total">شامل الضريبة: {{ number_format($item->amount + getTaxAmount($item->amount, $taxPercentage), 2, '.', ',') }} ر.س.</p>
                                        <p class="paid {{ $item->status == 'paid' ? '' : 'd-none' }}">مدفوع</p>
                                    </div>

                                </li>
                            @endforeach


                        </ul>

                        @if ($selectedServices->count())
                            <h6 class="sub_title mt-3">الخدمات الإضافية:</h6>
                            <ul>
                                @foreach ($selectedServices as $key => $item)
                                    <li>
                                        <span class="num">{{ $key + 1 }}</span>
                                        <div class="text">
                                            <p>{{ $item->title }}</p>
                                        </div>
                                        <div class="value payment-line-totals">
                                            <span class="payment-line-amount">{{ number_format($item->amount, 2, '.', ',') }} ر.س.</span>
                                            <p class="payment-line-tax">الضريبة: {{ number_format(getTaxAmount($item->amount, $taxPercentage), 2, '.', ',') }} ر.س.</p>
                                            <p class="payment-line-total">شامل الضريبة: {{ number_format($item->amount + getTaxAmount($item->amount, $taxPercentage), 2, '.', ',') }} ر.س.</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <h6 class="sub_title mt-3">الضريبة:</h6>
                        <ul>
                            <li>
                                <span class="num"></span>
                                <div class="text">
                                    <p>الضريبة</p>
                                </div>
                                <div class="value">
                                    <span>{{ number_format($contractTaxAmount, 2, '.', ',') }} ر.س.</span>
                                </div>
                            </li>
                        </ul>

                        <div class="total">
                            <div class="text">
                                <span>إجمالي قيمة المشروع</span>
                                <p>شامل جميع الدفعات والضريبة</p>
                            </div>
                            <div class="values">
                                {{-- <span>{{ $details['total_amount_with_extra'] }}</span> --}}
                                <span>{{ number_format($contractTotalWithTax, 2, '.', ',') }}</span>
                                <p>ريال سعودي</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="section_tap timeline ">

                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="box one mb-3 mb-md-0">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') }}</span>
                                <p>تاريخ البدء</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="box tow mb-3 mb-md-0">
                                <i class="fa-regular fa-clock"></i>
<span>
    {{ $offer->total_days }} يوم
</span>
                                <p>مدة التنفيذ</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="box three mb-3 mb-md-0">
                                <i class="fa-regular fa-circle-check"></i>
                                <span>{{ \Carbon\Carbon::parse($offer->expected_end_date)->format('Y-m-d') }}</span>
                                <p>تاريخ التسليم</p>
                            </div>
                        </div>
                    </div>

                    <h6 class="sub_title mt-3 mt-md-5">المعالم الزمنية:</h6>

                    <ul>

                        @foreach ($offer->itemsWithSelectedServices as $key => $item)
                            <li>
                                <span class="num paid">{{ $key + 1 }}</span>
                                <div class="text">
                                    <p>{{ $item->title }}</p>
                                    <div>
                                        <span>المدة المتوقعة: </span>
                                        <span> {{ $item->total_days }} يوم</span>
                                    </div>
                                </div>
                                <div class="value">
                                    <span>{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}</span>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>


                <div class="section_tap  reports">
                    <h5 class="taps_title mb-3">التقارير</h5>
                    <div class="report">
                        @foreach ($project->reports()->orderBy('id', 'desc')->get() as $item)
                            <div class="report">

                                <div class="report_name">
                                    <span class="bult">ك م</span>
                                    <div class="name">
                                        أضاف مهندس
                                        <span> {{ $item->author->full_name }} </span>
                                        تقريرًا {{ $item->type }} يحتوي على
                                        <span>{{ count($item->attachments) }}</span>
                                        صور
                                    </div>
                                </div>
                                <div class="report_content">
                                    <div class="wrapper">
                                        <div class="head">
                                            <h6>{{ $item->title }}</h6>
                                            <button>
                                                <i class="fa-regular fa-eye"></i>
                                                <span>عرض التقرير</span>
                                            </button>
                                        </div>
                                        <div class="description">
                                            <p> {{ $item->description }}</p>
                                        </div>
                                        <div class="info">
                                            <div class="items">
                                                <p>صور مرفقة</p>
                                                <span>{{ count($item->attachments) }}</span>
                                                <i class="fa-regular fa-camera"></i>
                                            </div>
                                            <div class="date">
                                                <span>
                                                    {{ $item->created_at->format('Y-m-d') }} --
                                                    {{ $item->created_at->format('g:i') }}
                                                    {{ $item->created_at->format('A') == 'AM' ? 'ص' : 'م' }}
                                                </span>
                                                <i class="fa-regular fa-calendar"></i>
                                            </div>
                                        </div>
                                        <div class="images">
                                            <div class="row">
                                                @foreach ($item->attachments as $image)
                                                    <div class="col-md-6 col-lg-3">
                                                        <div class="box">
                                                            <div class="image">
                                                                <img src="{{ Storage::url($image->file_path) }}"
                                                                    width="200" height="200" alt="">
                                                            </div>
                                                            <span>{{ $image->file_name }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



            </div>

            <div class="request_inspection ">
                <div class="wrapper">
                    <h6>تحديد موعد المعاينة</h6>
                    <form action="{{ route('customer.project.implementation.request.inspection', $project->id) }}"
                        method="POST">
                        <div class="new_date">
                            @csrf
                            <label for="inlineCalendar">اختر التاريخ الجديد</label>
                            <input type="text" name="new_date" id="inlineCalendar" hidden>
                        </div>
                        <div class="input_group">
                            <label for="time">اختر الوقت</label>
                            <input type="time" name="time" id="time">
                        </div>
                        <p class="note">ملاحظة: يمكن تغيير الموعد مرة واحدة فقط، ويجب أن يكون قبل الموعد المحدد بـ 24
                            ساعة على الأقل.</p>
                        <div class="buttons d-none">
                            <button class="main_btn_bg">تأكيد التغيير</button>
                            <button class="main_btn_bg cancel">إلغاء</button>
                        </div>
                    </form>
                    <div class="close_request_inspection">
                        <i class="fa-solid fa-x"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="/assets/js/customer/approval-details.js"></script>
    <script src="/assets/js/switch-tabs.js"></script>
    <script>
        function TogglePopUp(id) {

            $("#" + id).toggleClass("show");

        }
    </script>
@endpush
{{--  --}}
