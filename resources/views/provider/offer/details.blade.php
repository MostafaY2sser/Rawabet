@extends('provider.layouts.main')

@section('title')
    تفاصيل العرض
@endsection

    @php

        $depositemItem = $offer->deposite();
        $depositeAmount = number_format(($offer->total_amount * $depositemItem->percentage) / 100, 2);
        $PaymentSchedule =  $offer->paymentSchedules;

    @endphp


@section('content')
    <div class="offer_details project_details provider" id="main_page">
        <div class="project_info">
            <div class="head">
                <a href="{{route('provider.offers.index')}}" class="back">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للمشاريع</span>
                </a>
                     <div class="buttons">
                   
                    @if($canRate)
                    <a href="{{ route('provider.rate.create', $offer->id) }}" class="main_btn_bg different">
                        <span>تقييم العميل</span>
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
                {{ $offer->project?->buildingType?->name }}
            </h2>

            <div class="info">
                <div>
                 <span>
    {{ $offer->total_days }} يوم
</span>


                    <p>مدة الانتهاء المتوقعة:</p>
                    <img src="{{ asset('assets/images/customer/icons/culander.png') }}" alt="">

                </div>


                <div>
                    <span>{{$offer->project->city->name}}</span>
                    <img src="{{ asset('assets/images/customer/icons/location.png') }}" alt="">
                </div>
                <div>
                    <p>ريال</p>
                    <span>{{ number_format($offer->total_amount) }}</span>
                    <img src="{{ asset('assets/images/customer/icons/budget.png') }}" alt="">
                </div>
                <div class="offers">
                    <span>عرض مقدم</span>
                    <p>{{ count($offer->project->offers) }}</p>
                    <img src="{{ asset('assets/images/customer/icons/globe.png') }}" alt="">
                </div>
            </div>
        </div>



        <div class="about_project">

            <div class="buttons_tap">
                <ul id="menu-tabs">
                    <li data-target="offerDetails" >
                        <i class="fa-regular fa-file-lines"></i>
                        <span>تفاصيل العرض</span>
                    </li>
                    <li data-target="WorkItems">
                        <i class="fa-regular fa-circle-check"></i>
                        <span>بنود العمل</span>
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
                        <i class="fa-regular fa-eye"></i>
                        <span>المستندات</span>
                    </li>
                </ul>
            </div>

            <div class="contents">
                <div class="section_tap offerDetails ">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="box salary">
                                <div class="title">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                    <p>إجمالي قيمة العرض</p>
                                </div>
                                <span class="value">{{ number_format($offer->total_amount) }}</span>
                                <span class="sub">ريال سعودي</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="box  dateline">
                                <div class="title">
                                    <i class="fa-regular fa-calendar"></i>
                                    <p>مدة التنفيذ</p>
                                </div>


                               <span>
    {{$offer->total_days }} يوم
</span>


                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="box  submition">
                                <div class="title">
                                    <i class="fa-regular fa-clock"></i>
                                    <p>تاريخ التقديم</p>
                                </div>
                                @php
                                    use Carbon\Carbon;
                                    Carbon::setLocale('ar');
                                    $date = Carbon::now();
                                @endphp
                                <span class="value">{{ $date->translatedFormat('j F Y') }}</span>
                                <span class="sub">{{ $date->translatedFormat('l') }}</span>

                            </div>
                        </div>
                    </div>
                    <div class="offer_note">
                        <h6>ملاحظات العرض</h6>
                        <p class="response_status">
                            {{ \App\Enums\OfferStatus::getLabel($offer->status) }}
                        </p>


                    </div>
                    <div class="important_info">
                        <div>
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>معلومات مهمة</span>
                        </div>
                        <p>يرجى مراجعة جميع بنود العرض والتأكد من دقة المعلومات قبل التقديم النهائي. لا يمكن تعديل العرض بعد
                            التقديم إلا في حالة طلب التعديل من الإدارة.</p>
                    </div>
                </div>


                <div class="section_tap WorkItems ">

                    <h6>بنود العمل المقترحة</h6>

                    <div class="items_list">
                        @if($offer->items && $offer->items->count() > 0)
                            @foreach($offer->items as $item)
                                <div class="item">
                                    <h5>{{ $item->title }}</h5>

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
                                                    <h4>{{ Carbon::parse($item->start_date)->format('Y-m-d') }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="box">
                                                <span class="icon"><i class="fa-regular fa-clock"></i></span>
                                                <div class="text">
                                                    <span>مدة التنفيذ (أيام)</span>
                                                    <h4>{{ $item->total_days }}</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3">
                                            <div class="box">
                                                <span class="icon"><i class="fa-solid fa-dollar-sign"></i></span>
                                                <div class="text">
                                                    <span>قيمة الدفعة</span>
                                                    <h4>{{ number_format($item->amount) }} ر.س</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="technical">
                                        <span>المواصفات الفنية</span>
                                        <p>
                                            {{ $item->specifications }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>لا توجد بنود عمل مقترحة.</p>
                        @endif
                    </div>

                </div>


                <div class="section_tap paymentSchedule ">
                    <h6>جدول الدفعات:</h6>
                    <ul>
                        @if($PaymentSchedule)
                            @foreach($PaymentSchedule as $index => $item)
                                <li>
                                    <span class="num {{ $item->status == "paid" ? "paid" : "" }}">{{ $index + 1 }}</span>
                                    <div class="text">
                                        <p>{{ $item->title }}</p>
                                        <span>{{ $item->percentage }}% من إجمالي العقد</span>
                                    </div>
                                    <span class="value">{{ number_format(($offer->total_amount * $item->percentage) / 100, 2)}} ر.س.</span>
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


                <div class="section_tap timeline  ">
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
                                <i class="fa-regular fa-clock"></i>
                                <span>{{ Carbon::parse($offer->expected_end_date)->translatedFormat('j F Y') }}</span>
                                <p>تاريخ الانتهاء المتوقع</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="box">
                                <i class="fa-regular fa-circle-check"></i>
<span>
    {{ $offer->total_days }} يوم
</span>
                                <p>المدة الكلية</p>
                            </div>
                        </div>
                    </div>

                    <h6 class="mt-5">المعالم الزمنية:</h6>
                    <ul>
                        @foreach($offer->items as $index => $item)
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



                <div class="section_tap documents">
                   <div class="row">
                            @foreach ($attachments as $key=>$list)

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
                                    <a class="main_btn_bg preview" href="{{ route('provider.project.download.file' , $file->id) }}">
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

<script src="../../../../assets/js/switch-tabs.js"></script>

@endpush