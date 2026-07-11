edit
@extends('admin.layouts.main')

@php

@endphp
@section('title')
    تفاصيل العرض {{ $offer->project?->reference_number }}
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@php
    
    $PaymentSchedule = $offer->paymentSchedules;


@endphp


@section('content')
    <div class="offer_details project_details provider" id="main_page">
        <div class="project_info">
            <div class="head">
                <a href="{{ route('admin.offers.pending.index') }}" class="back">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>العودة للعروض</span>
                </a>

                <div class="d-flex gap-2">

                    @if($offer->status == \App\Enums\OfferStatus::PENDING->value)
                    @can('approve offers.pending')
                    <form action="{{ route('admin.offers.pending.approve', $offer->id) }}" method="POST"
                        style="display:inline;" onsubmit="return confirm('هل أنت متأكد من تنشيط هذا العرض؟')">
                        @csrf
                        <button type="submit" class="main_btn_bg">تنشيط</button>
                    </form>

                    @endcan
                    @can('view offers.additionalServices')
                        
                    <a href="{{ route('admin.offers.pending.additionalServices.index', $offer->id) }}" class="main_btn_bg">
                        خدمات إضافية
                    </a>
                    @endcan

                    @endif

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
            <p class="reference_number">{{ $offer->project?->reference_number }}</p>

            <div class="info">
                <div>
                    <span>
                          {{ $offer->total_days }} يوم

                    </span>

                    <p>مدة الانتهاء المتوقعة:</p>
                    <img src="{{ asset('assets/images/customer/icons/culander.png') }}" alt="">

                </div>


                <div>
                    <span>{{ $offer->project->city->name }}</span>
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
                    <li data-target="offerDetails">
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
                                    <p>إجمالي قيمة العرض</p>
                                </div>
                                <span class="value">{{$details['total_amount_with_extra'] }}</span>
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
    {{ $offer->total_days }} يوم
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
                        @if ($offer->itemsWithSelectedServices && $offer->itemsWithSelectedServices->count() > 0)
                            @foreach ($offer->itemsWithSelectedServices as $item)
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
                                                    <h4>{{ number_format($item->paymentSchedule?->amount ?? $item->amount) }} ر.س</h4>
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


                {{-- <div class="section_tap paymentSchedule ">
                    <h6>جدول الدفعات:</h6>
                    <ul>
                        @if ($PaymentSchedule)
                        @foreach ($PaymentSchedule as $index => $item)
                        <li>
                            <span class="num {{ $item->status == " paid" ? "paid" : "" }}">{{ $index + 1 }}</span>
                            <div class="text">
                                <p>{{ $item->title }}</p>
                                <span>{{ $item->percentage }}% من إجمالي العقد</span>

                            </div>
                            <span class="value">{{ number_format(($offer->total_amount * $item->percentage) / 100, 2)}}
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
                </div> --}}


                <div class="section_tap paymentSchedule ">
                    <h6>جدول الدفعات:</h6>

                    <form action="{{ route('admin.offers.pending.paymentSchedules.update', $offer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <ul>
                            @if ($offer->paymentSchedules && $offer->paymentSchedules->count())
                                @foreach ($offer->paymentSchedules as $index => $item)
                                    <li>
                                        <span
                                            class="num {{ $item->status == 'paid' ? 'paid' : '' }}">{{ $index + 1 }}</span>
                                        <div class="text">
                                            <p>{{ $item->title }}</p>
                                            <span>
                                                <input type="number" name="schedules[{{ $item->id }}][percentage]"
                                                    value="{{ $item->percentage }}" step="0.01" min="0"
                                                    max="100" class="form-control d-inline-block"
                                                    style="width: 100px;">
                                                % من إجمالي العقد
                                            </span>
                                        </div>
                                        <span class="value amount-display">
                                            {{ number_format(($item->amount), 2) }} ر.س.
                                        </span>
                                    </li>
                                @endforeach
                            @else
                                <li>لا توجد دفعات مقترحة.</li>
                            @endif
                        </ul>

                         <h6>الخدمات الاضافية المقترحة:</h6>

                           <ul>
                            @if ($offer->additionalServices && $offer->additionalServices->count())
                                @foreach ($offer->additionalServices as $index => $item)
                                    <li>
                                        <span
                                            class="num {{ $item->status == 'paid' ? 'paid' : '' }}">{{ $index + 1 }}</span>
                                        <div class="text">
                                            <p>{{ $item->title }}</p>
                                         
                                        </div>
                                        <span class="value amount-display">
                                            {{ number_format(($item->amount), 2) }} ر.س.
                                        </span>
                                    </li>
                                @endforeach
                            @else
                                <li>لا توجد</li>
                            @endif
                        </ul>
                         <h6>الضريبة:</h6>

                           <ul>
                            <li>
                                <span></span>
                                <div class="text">
                                    <p>الضريبة</p>
                                </div>
                                <span class="value amount-display">
                                    {{ number_format(getTaxAmount($details['total_amount_with_extra'], $details['tax_percentage']), 2) }} ر.س.
                                </span>
                            </li>
                        </ul>
                        <div class="total">
                            <div class="text">
                                <span>إجمالي قيمة المشروع</span>
                                <p>شامل جميع الدفعات</p>
                            </div>
                            <div class="values">
                                <span>{{ number_format($details['total_amount_with_extra'] + getTaxAmount($details['total_amount_with_extra'], $details['tax_percentage'])) }}</span>
                                <p>ريال سعودي</p>
                            </div>
                        </div>

                        <button type="submit" class="main_btn_bg mt-3">تحديث جدول الدفعات</button>
                    </form>
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
                        @foreach ($offer->itemsWithSelectedServices as $index => $item)
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
                                            <button class="main_btn_bg preview"
                                                onclick="previewFile('{{ Storage::url($file->file_path) }}')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="main_btn_bg download"
                                                onclick="downloadFile('{{ Storage::url($file->file_path) }}')">
                                                <i class="fas fa-download"></i>
                                            </button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const totalAmount = {{ $offer->total_amount }};
            const inputs = document.querySelectorAll('input[name^="schedules"]');
            const form = document.querySelector('form[action*="payment-schedules"]');

            // تحديث القيمة مباشرة لما المستخدم يغير النسبة
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    let percentage = parseFloat(this.value) || 0;
                    let amount = (totalAmount * percentage) / 100;

                    this.closest('li').querySelector('.amount-display').innerText =
                        amount.toFixed(2) + ' ر.س.';
                });
            });
            form.addEventListener('submit', function(e) {
                let totalPercentage = 0;

                inputs.forEach(input => {
                    totalPercentage += parseFloat(input.value) || 0;
                });

                if (totalPercentage !== 100) {
                    e.preventDefault();
                    alert("⚠ مجموع النسب لازم يكون 100%. المجموع الحالي: " + totalPercentage + "%");
                }
            });
        });
    </script>
@endpush
