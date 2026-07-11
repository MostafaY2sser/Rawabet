@extends('customer.layouts.main')
@section('content')
    @php
        $depositemItem = $offer->deposite();
        $contractSubtotal = $details['total_amount_with_extra'];
        $contractTaxAmount = $details['tax_amount'];
        $contractTotalWithTax = $details['total_amount_with_tax'];
        $depositeAmount = $details['deposite_amount'];
        $depositeTaxAmount = $details['deposite_tax_amount'];
        $depositeAmountWithTax = $details['deposite_amount_with_tax'];
        $remainingAmount = $details['remaining_with_tax'];
        $paidDepositAmount = $offer->contract?->deposit ? (float) $offer->contract->deposit : $depositeAmountWithTax;
        $remainingBalance = $offer->contract?->remaining ? (float) $offer->contract->remaining : $remainingAmount;
        $PaymentSchedule = $offer->paymentSchedules;
    @endphp
    <style>
        .payment{
            margin-top: 0;
        }
    </style>
    <div class="payment">
        <div class="wrapper">


            <div class="head">
                <h6>الدفع والتعاقد</h6>

                <ul class="payment_steper">
                    <li class="{{ $step == 'deposite' ? 'active' : '' }}">
                        <p>الدفع الأولي</p>
                        <span>01</span>
                    </li>
                    <li class="@if ($step == 'mobile_verification' || $step == 'contract_sign') active @endif
                            ">
                        <p>التوقيع الإلكتروني</p>
                        <span>02</span>
                    </li>
                    <li class="{{ $step == 'project_start' ? 'active' : '' }}">
                        <p>بدء المشروع</p>
                        <span>03</span>
                    </li>
                </ul>

                <a href="{{route('customer.project.index')}}" class="close">
                    <i class="fa-solid fa-xmark"></i>
                </a>

            </div>

            <div class="step_section  payment_method "
                @if ($step == 'deposite') style="display: block" @else
            style="display: none" @endif>

                <div class="top">
                    <h6>دفع العربون</h6>
                    <p class="choose">راجع ملخص الدفع ثم تابع عبر بوابة MyFatoorah</p>
                </div>

                <div class="row justify-content-center">

                    <div class="col-md-8 d-none">
                        <form action="{{ route('customer.payment.deposite.payment') }}" id="paymentForm" method="POST">
                            @csrf
                            <div class="bg_white">

                                <div class="payment_options" id="paymentMethods">
                                    @csrf
                                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                                    <input type="hidden" name="amount" value="{{ $depositeAmountWithTax }}">

                                    <label class="option">
                                        <i class="fa-regular fa-credit-card icon"></i>
                                        <div class="info">
                                            <strong>بطاقة ائتمانية</strong>
                                            <span>فيزا، ماستركارد، أمريكان إكسبريس</span>
                                        </div>
                                        <input type="radio" name="payment" value="credit" />
                                    </label>

                                    <label class="option">
                                        <i class="fa-solid fa-credit-card icon"></i>
                                        <div class="info">
                                            <strong>بطاقة مدى</strong>
                                            <span>البطاقات السعودية المحلية</span>
                                        </div>
                                        <input type="radio" name="payment" value="mada" />
                                    </label>

                                    <label class="option">
                                        <i class="fa-solid fa-building-columns icon"></i>
                                        <div class="info">
                                            <strong>تحويل بنكي</strong>
                                            <span>تحويل مباشر من حسابك البنكي</span>
                                        </div>
                                        <input type="radio" name="payment" value="bank" />
                                    </label>

                                    <label class="option">
                                        <i class="fa-solid fa-wallet icon"></i>
                                        <div class="info">
                                            <strong>STC Pay</strong>
                                            <span>محفظة STC الرقمية</span>
                                        </div>
                                        <input type="radio" name="payment" value="stc" />
                                    </label>

                                    <label class="option">
                                        <i class="fa-brands fa-apple icon"></i>
                                        <div class="info">
                                            <strong>Apple Pay</strong>
                                            <span>الدفع عبر Apple Pay</span>
                                        </div>
                                        <input type="radio" name="payment" value="apple" />
                                    </label>
                                </div>

                                <div class="payment_details">
                                    <div class="input_group">
                                        <label for="cart_number">رقم البطاقة *</label>
                                        <input type="text" name="cart_number" id="cart_number"
                                            placeholder="1234 5678 9012 3456" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input_group">
                                                <label for="security_code"> رمز الامان *</label>
                                                <input type="text" name="security_code" id="security_code"
                                                    placeholder="123" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input_group">
                                                <label for="expiration_date">تاريخ الانتهاء *</label>
                                                <input type="date" name="expiration_date" id="expiration_date"
                                                    placeholder="MM/YY" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input_group">
                                        <label for="user">اسم حامل البطاقة *</label>
                                        <input type="text" name="user" id="user"
                                            placeholder="الاسم كما هو مكتوب على البطاقة" required>
                                    </div>
                                </div>
                            </div>

                            <label class="financial_guarantee">
                                <input type="checkbox" name="financial_guarantee" value="financial_guarantee" />
                                <div class="info">
                                    <span>أوافق على نظام الضمان المالي (Escrow)</span>
                                    <p>المبلغ سيتم حجزه بشكل آمن في المنصة ولن يتم تحويله للمقاول إلا بعد إنجاز المراحل
                                        المتفق
                                        عليها</p>
                                </div>
                            </label>
                            <label class="terms_conditions">
                                <input type="checkbox" name="terms_conditions" value="terms_conditions" />
                                <div class="info">
                                    <span>أوافق على شروط وأحكام المنصة وسياسة الاسترداد</span>
                                    <p>بالموافقة، أنت تقر بقراءة وفهم جميع الشروط والأحكام المتعلقة بالدفع والتعاقد</p>
                                </div>
                            </label>

                        </form>
                    </div>


                    <div class="col-md-6 col-lg-5">
                        <div class="summry">
                            <div class="title">
                                <span><i class="fa-solid fa-dollar-sign"></i></span>
                                <h6>ملخص الدفع</h6>
                            </div>
                            <div class="lines">
                                <div class="total">
                                    <p>قيمة المشروع:</p>
                                    <span>{{ number_format($contractSubtotal, 2) }} ر.س.</span>
                                </div>
                                <div class="total">
                                    <p>ضريبة المشروع:</p>
                                    <span>{{ number_format($contractTaxAmount, 2) }} ر.س.</span>
                                </div>
                                <div class="total">
                                    <p>إجمالي قيمة المشروع شامل الضريبة:</p>
                                    <span>{{ number_format($contractTotalWithTax, 2) }} ر.س.</span>
                                </div>
                                <div class="center">
                                    <div class="deposit">
                                        <p>(%{{ $depositemItem->percentage }}) :العربون المطلوب</p>
                                        <span>{{ number_format($depositeAmount, 2) }} ر.س.</span>
                                    </div>
                                    <div class="deposit">
                                        <p>ضريبة العربون:</p>
                                        <span>{{ number_format($depositeTaxAmount, 2) }} ر.س.</span>
                                    </div>
                                    <div class="deposit">
                                        <p>إجمالي العربون المطلوب:</p>
                                        <span>{{ number_format($depositeAmountWithTax, 2) }} ر.س.</span>
                                    </div>
                                    <div class="remaining">
                                        <p>المبلغ المتبقي:</p>
                                        <span>{{ number_format($remainingAmount, 2) }} ر.س.</span>
                                    </div>
                                </div>
                             
                            </div>

                            <div class="security_guarantee">
                                <div>
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <p>ضمان الأمان</p>
                                </div>
                                <ul>
                                    <li>• المبلغ محجوز بشكل آمن</li>
                                    <li>• حماية كاملة لحقوقك</li>
                                    <li>• استرداد فوري في حالة المشاكل</li>
                                </ul>
                            </div>

                            <a class="main_btn_bg" href="/myfatoorah?of-id={{$offer->id}}&de-id={{ $depositemItem->id }}" >
                                <i class="fa-solid fa-lock"></i>
                                <span>دفع العربون الآن</span>
                            </a>

                            <p class="click">بالنقر على "دفع العربون الآن" أنت توافق على جميع الشروط والأحكام</p>

                        </div>
                    </div>

                </div>

            </div>



            <div class="step_section electronic_signature" @if ($step == 'mobile_verification' || $step == 'contract_sign') style="display: block" @else style="display: none" @endif>

                <div class="title">
                    <div class="text">
                        <h6>عقد مقاولة بناء</h6>
                        <div>
                            <p>: رقم العقد</p>
                            <span>CNT-1-2024</span>
                        </div>
                    </div>

                    <button class="main_btn_bg">
                        <i class="fa-solid fa-download"></i>
                        <span>تحميل PDF</span>
                    </button>
                </div>


                <div class="row">

                    <div class="col-md-8">
                        <div class="empty">

                        </div>

                        <div class="financial_terms summry my-3">
                            <div class="share_head">
                                <span><i class="fa-solid fa-dollar-sign"></i></span>
                                <h6>الشروط المالية</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-4 ">
                                    <div class="box one mb-3 mb-md-0">
                                        <h4>{{ number_format($remainingBalance, 2) }} ر.س.</h4>
                                            <span>المبلغ المتبقي</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="box tow mb-3 mb-md-0">
                                        <h4>{{ number_format($paidDepositAmount, 2) }} ر.س.</h4>
                                            <span>العربون المدفوع</span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="box three mb-3 mb-md-0">
                                        <h4>{{ number_format($contractTotalWithTax, 2) }} ر.س.</h4>
                                            <span>إجمالي قيمة العقد</span>
                                    </div>
                                </div>
                            </div>

                            <h6 class="sub_title">جدول الدفعات:</h6>

                            <ul>

                                @foreach ($offer->paymentSchedules as $key => $item)
                                    <li>
                                        <span class="num {{ $item->status == 'paid' ? 'paid' : '' }}">{{ $key + 1 }}</span>
                                        <div class="text">
                                            <p>{{ $item->title }}</p>
                                            @if ($item->percentage > 0)
                                                <div>
                                                    <span>{{ $item->percentage }}% من إجمالي العقد</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="value">
                                            @if ($item->status == 'paid')
                                                <p class="paid">مدفوع</p>
                                            @else
                                                <span>{{ number_format($item->amount, 2) }} ر.س.</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach

                            </ul>

                            @if ($selectedServices->count())
                                <h6 class="sub_title">الخدمات الإضافية:</h6>
                                <ul>
                                    @foreach ($selectedServices as $key => $item)
                                        <li>
                                            <span class="num">{{ $key + 1 }}</span>
                                            <div class="text">
                                                <p>{{ $item->title }}</p>
                                            </div>
                                            <div class="value">
                                                <span>{{ number_format($item->amount, 2) }} ر.س.</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <h6 class="sub_title">الضريبة:</h6>
                            <ul>
                                <li>
                                    <span class="num"></span>
                                    <div class="text">
                                        <p>الضريبة</p>
                                    </div>
                                    <div class="value">
                                        <span>{{ number_format($contractTaxAmount, 2) }} ر.س.</span>
                                    </div>
                                </li>
                            </ul>

                            <div class="total">
                                <div class="text">
                                    <span>إجمالي قيمة المشروع</span>
                                    <p>شامل جميع الدفعات والضريبة</p>
                                </div>
                                <div class="values">
                                    <span>{{ number_format($contractTotalWithTax, 2) }}</span>
                                    <p>ريال سعودي</p>
                                </div>
                            </div>

                        </div>

                        <div class="timeline summry my-3">
                            <div class="share_head">
                                <span><i class="fa-regular fa-calendar"></i></span>
                                <h6>الجدول الزمني</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="box one mb-3 mb-md-0">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $offer->start_date }}</span>
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
                                        <span>{{ $offer->expected_end_date }}</span>
                                        <p>تاريخ التسليم</p>
                                    </div>
                                </div>
                            </div>

                            <h6 class="sub_title">المعالم الزمنية:</h6>

                            <ul>
                                @foreach ($offer->items as $key => $item)
                                    <li>
                                        <span class="num {{ $key == 0 ? 'paid' : '' }}">{{ $key + 1 }}</span>
                                        <div class="text">
                                            <p>{{ $item->title }}</p>
                                            <div>
                                                <span>المدة المتوقعة: </span>
                                                <span>{{ $item->total_days }}يوم</span>
                                            </div>
                                        </div>
                                        <div class="value">
                                            <span>{{ $item->start_date }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="signature summry">
                            <div class="top">
                                <span><i class="fa-regular fa-pen-to-square"></i></span>
                                <h6> التوقيع الإلكتروني</h6>
                            </div>
                            <form id="mobileVerify" action="{{ route('customer.contract.verify.mobile') }}"
                                method="POST">
                                @csrf
                                <div class="identity_verification {{ $step == 'mobile_verification' ? '' : 'd-none' }}">
                                    <i class="fa-solid fa-phone"></i>
                                    <div class="text">
                                        <span>التحقق من الهوية:</span>
                                        <p>سيتم إرسال رمز التحقق إلى رقم هاتفك المسجل</p>
                                        <input type="text" name="phone" id="phone"
                                            value="{{ $offer->project->customer->phone_number }}" readonly>
                                    </div>
                                </div>

                                <div class="verification_done " style="display: none" id="otp_sent">
                                    <img src="../../public/assets/images/customer/icons/green-check.png" alt="">
                                    <p>تم إرسال رمز التحقق إلى هاتفك</p>
                                </div>

                                <div class="agree_terms mt-4  {{ $step == 'contract_sign' ? '' : 'd-none' }}">
                                    <input type="checkbox" name="agree_terms" id="agree_terms" required>
                                    <div class="text">
                                        <span>أوافق على جميع بنود العقد المذكورة أعلاه *</span>
                                        <p>بالموافقة، أنت تقر بقراءة وفهم جميع شروط العقد والالتزام بها</p>
                                    </div>
                                </div>

                                <div class="additional_notes mt-3  {{ $step == 'contract_sign' ? '' : 'd-none' }}"
                                    id="additionl_notes">
                                    <div class="signature_input mt-3 {{ $step == 'contract_sign' ? '' : 'd-none' }}">
                                        <label for="signature">التوقيع الإلكتروني *</label>
                                        <br>
                                        <canvas id="signature-pad"
                                            style="border: 1px solid #ccc; width: 100%; height: 200px; border-radius: 8px;"></canvas>
                                        <input type="hidden" name="signature" id="signature">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-secondary"
                                                id="clear-signature">مسح</button>
                                        </div>
                                    </div>

                                    <div class="input_group">
                                        <label for="additional_notes">ملاحظات إضافية (اختياري)</label>
                                        <textarea name="additional_notes" id="additional_notes" placeholder="أي ملاحظات أو تعديلات تود إضافتها..."></textarea>
                                    </div>
                                    @foreach ($selectedServices as $item)
                                        <input type="hidden" name="services[]" value="{{ $item->id }}">
                                    @endforeach
                                </div>

                                <input type="hidden" value="{{ $offer->id }}" name="offer_id">
                                <div class="verification_code" style="display: none" id="otp_input">
                                    <div class="input_group mt-3">
                                        <label for="verification_code">*أدخل رمز التحقق</label>
                                        <input type="text" name="verification_code" id="verification_code"
                                            placeholder="12345" required>
                                    </div>
                                </div>

                                <button class="main_btn_bg {{ $step == 'mobile_verification' ? '' : 'd-none' }}"
                                    id="send_otp" style="background: #F5932E">
                                    <i class="fa-brands fa-telegram"></i>
                                    <span>إرسال رمز التحقق</span>
                                </button>
                                <button class="main_btn_bg " style="display: none" id="otp_submit">
                                    <span>تأكيد الرمز</span>
                                    <i class="fa-solid fa-lock"></i>
                                </button>
                                <button class="main_btn_bg green {{ $step == 'contract_sign' ? '' : 'd-none' }}"
                                    id="contractSign" type="button">
                                    <span>توقيع العقد إلكترونياً</span>
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <form action="" id="contractSignForm" class="d-none">
                                    @csrf
                                </form>
                            </form>

                            <div class="legal_notice">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div class="text">
                                    <span>تنبيه قانوني:</span>
                                    <p>التوقيع الإلكتروني له نفس القوة القانونية للتوقيع التقليدي وفقاً لنظام التعاملات
                                        الإلكترونية السعودي</p>
                                </div>
                            </div>

                        </div>

                        <div class="contract_summary summry my-4">
                            <h6>ملخص العقد</h6>
                            <ul>
                                <li>
                                    <p>قيمة العقد:</p>
                                    <span>{{ number_format($contractSubtotal, 2) }} ر.س.</span>
                                </li>
                                <li>
                                    <p>الضريبة:</p>
                                    <span>{{ number_format($contractTaxAmount, 2) }} ر.س.</span>
                                </li>
                                <li>
                                    <p>إجمالي العقد شامل الضريبة:</p>
                                    <span>{{ number_format($contractTotalWithTax, 2) }} ر.س.</span>
                                </li>
                                <li>
                                    <p>العربون المدفوع:</p>
                                    <span>{{ number_format($paidDepositAmount, 2) }} ر.س.</span>
                                </li>
                                <li>
                                    <p>المبلغ المتبقي:</p>
                                    <span>{{ number_format($remainingBalance, 2) }} ر.س.</span>
                                </li>
                                <li>
                                    <p>مدة التنفيذ:</p>
<span>
    {{ $offer->total_days }} يوم
</span>
                                </li>
                                <li>
                                    <p>تاريخ البدء:</p>
                                    <span>{{ $offer->start_date }}</span>
                                </li>
                                <li>
                                    <p>تاريخ التسليم:</p>
                                    <span>{{ $offer->expected_end_date }}</span>
                                </li>
                            </ul>
                            <div class="payment_status">
                                <p>حالة الدفع:</p>
                                <span> العربون مدفوع ✓</span>
                            </div>
                        </div>

                        <div class="legal_protection summry">
                            <h6>الحماية القانونية</h6>
                            <ul>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6654 7.38527V7.99861C14.6645 9.43622 14.199 10.8351 13.3383 11.9865C12.4775 13.1379 11.2676 13.9803 9.88894 14.3879C8.51032 14.7955 7.03687 14.7465 5.68835 14.2483C4.33982 13.7501 3.18847 12.8293 2.406 11.6233C1.62354 10.4173 1.25189 8.99065 1.34648 7.55615C1.44107 6.12165 1.99684 4.75616 2.93088 3.66332C3.86493 2.57049 5.12722 1.80886 6.52949 1.49204C7.93176 1.17521 9.39888 1.32017 10.712 1.90527"
                                            stroke="#F5932E" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 7.33464L8 9.33464L14.6667 2.66797" stroke="#F5932E"
                                            stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>عقد معتمد قانونياً</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6654 7.38527V7.99861C14.6645 9.43622 14.199 10.8351 13.3383 11.9865C12.4775 13.1379 11.2676 13.9803 9.88894 14.3879C8.51032 14.7955 7.03687 14.7465 5.68835 14.2483C4.33982 13.7501 3.18847 12.8293 2.406 11.6233C1.62354 10.4173 1.25189 8.99065 1.34648 7.55615C1.44107 6.12165 1.99684 4.75616 2.93088 3.66332C3.86493 2.57049 5.12722 1.80886 6.52949 1.49204C7.93176 1.17521 9.39888 1.32017 10.712 1.90527"
                                            stroke="#F5932E" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 7.33464L8 9.33464L14.6667 2.66797" stroke="#F5932E"
                                            stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>نظام الضمان المالي (Escrow)</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6654 7.38527V7.99861C14.6645 9.43622 14.199 10.8351 13.3383 11.9865C12.4775 13.1379 11.2676 13.9803 9.88894 14.3879C8.51032 14.7955 7.03687 14.7465 5.68835 14.2483C4.33982 13.7501 3.18847 12.8293 2.406 11.6233C1.62354 10.4173 1.25189 8.99065 1.34648 7.55615C1.44107 6.12165 1.99684 4.75616 2.93088 3.66332C3.86493 2.57049 5.12722 1.80886 6.52949 1.49204C7.93176 1.17521 9.39888 1.32017 10.712 1.90527"
                                            stroke="#F5932E" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 7.33464L8 9.33464L14.6667 2.66797" stroke="#F5932E"
                                            stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>تأمين شامل ضد المخاطر</p>
                                </li>
                                <li>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.6654 7.38527V7.99861C14.6645 9.43622 14.199 10.8351 13.3383 11.9865C12.4775 13.1379 11.2676 13.9803 9.88894 14.3879C8.51032 14.7955 7.03687 14.7465 5.68835 14.2483C4.33982 13.7501 3.18847 12.8293 2.406 11.6233C1.62354 10.4173 1.25189 8.99065 1.34648 7.55615C1.44107 6.12165 1.99684 4.75616 2.93088 3.66332C3.86493 2.57049 5.12722 1.80886 6.52949 1.49204C7.93176 1.17521 9.39888 1.32017 10.712 1.90527"
                                            stroke="#F5932E" stroke-width="1.33333" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6 7.33464L8 9.33464L14.6667 2.66797" stroke="#F5932E"
                                            stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>حل النزاعات وفقاً للأنظمة السعودية</p>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>


            <div class="step_section start_project "
                @if ($step != 'project_start') style="display: none" ; @else
            style="display: block" @endif>
                <section class="contract-success">
                    <div class="header">
                        <div class="cnt">
                            <svg width="24" height="16" viewBox="0 0 24 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2116_15222)">
                                    <path
                                        d="M21.3346 8.66566C21.3346 11.999 19.0013 13.6657 16.228 14.6323C16.0827 14.6815 15.925 14.6792 15.7813 14.6257C13.0013 13.6657 10.668 11.999 10.668 8.66566V3.999C10.668 3.82219 10.7382 3.65262 10.8632 3.52759C10.9883 3.40257 11.1578 3.33233 11.3346 3.33233C12.668 3.33233 14.3346 2.53233 15.4946 1.519C15.6359 1.39833 15.8155 1.33203 16.0013 1.33203C16.1871 1.33203 16.3667 1.39833 16.508 1.519C17.6746 2.539 19.3346 3.33233 20.668 3.33233C20.8448 3.33233 21.0143 3.40257 21.1394 3.52759C21.2644 3.65262 21.3346 3.82219 21.3346 3.999V8.66566Z"
                                        stroke="#166534" stroke-width="1.33333" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_2116_15222">
                                        <rect width="16" height="16" fill="white" transform="translate(8)" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <p>عقد نشط رقم {{ $offer->contract?->reference }}</p>
                        </div>
                        <div class="big-img">
                            <svg width="65" height="64" viewBox="0 0 65 64" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M58.8355 26.6666C60.0533 32.6434 59.1854 38.8571 56.3764 44.2714C53.5674 49.6857 48.9872 53.9734 43.3995 56.4195C37.8118 58.8655 31.5545 59.3221 25.6709 57.713C19.7874 56.1038 14.6333 52.5264 11.0682 47.5771C7.50311 42.6278 5.74248 36.6059 6.07992 30.5157C6.41737 24.4254 8.8325 18.6349 12.9226 14.1098C17.0126 9.58464 22.5304 6.59845 28.5557 5.64918C34.5809 4.69991 40.7496 5.84493 46.0328 8.8933"
                                    stroke="#F5932E" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M24.6992 29.3346L32.6992 37.3346L59.3659 10.668" stroke="#F5932E"
                                    stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="start-text">
                            <h3>مبروك! تم توقيع العقد بنجاح</h3>
                            <span>تم توقيع عقد "{{ $offer->project->serviceType->name }}
                                {{ $offer->project->buildingType->name }}" إلكترونياً وأصبح ساري المفعول</span>
                            <div class="all-time">
                                <div class="time">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.3997 18.3346C15.0021 18.3346 18.7331 14.6037 18.7331 10.0013C18.7331 5.39893 15.0021 1.66797 10.3997 1.66797C5.79737 1.66797 2.06641 5.39893 2.06641 10.0013C2.06641 14.6037 5.79737 18.3346 10.3997 18.3346Z"
                                            stroke="#F5932E" stroke-width="1.66667" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M10.3984 5V10L13.7318 11.6667" stroke="#F5932E" stroke-width="1.66667"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    @php
                                        $time = $offer->contract?->signature_time;
                                        $formattedTime = null;

                                        if ($time) {
                                            $hour = \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H');
                                            $period = $hour < 12 ? 'ص' : 'م';
                                            $formattedTime =
                                                \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i') .
                                                ' ' .
                                                $period;
                                        }
                                    @endphp


                                    <p>وقت التوقيع:{{ $formattedTime }} </p>
                                </div>
                                <div class="time">

                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.82031 1.66797V5.0013" stroke="#F5932E" stroke-width="1.66667"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M13.4844 1.66797V5.0013" stroke="#F5932E" stroke-width="1.66667"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path
                                            d="M15.9857 3.33203H4.31901C3.39854 3.33203 2.65234 4.07822 2.65234 4.9987V16.6654C2.65234 17.5858 3.39854 18.332 4.31901 18.332H15.9857C16.9062 18.332 17.6523 17.5858 17.6523 16.6654V4.9987C17.6523 4.07822 16.9062 3.33203 15.9857 3.33203Z"
                                            stroke="#F5932E" stroke-width="1.66667" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M2.65234 8.33203H17.6523" stroke="#F5932E" stroke-width="1.66667"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>تاريخ التوقيع: {{ $offer->contract?->signature_date }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-md-4">
                        <div class="col-lg-7">
                            <div class="box-1">
                                <h4>الخطوات التالية</h4>
                                <p>ما يجب فعله بعد توقيع العقد</p>
                                <div class="card">
                                    <span class="n">1</span>
                                    <div class="header-of-box ">
                                        <h4>التواصل مع المقاول</h4>
                                        <p>سيتواصل معك مدير المشروع خلال 24 ساعة لتنسيق بداية الأعمال</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <span class="n">2</span>
                                    <div class="header-of-box ">
                                        <h4>معاينة الموقع</h4>
                                        <p>سيتم تحديد موعد لمعاينة الموقع والتأكد من جاهزيته لبداية الأعمال</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <span class="n">4</span>
                                    <div class="header-of-box ">
                                        <h4>بداية التنفيذ</h4>
                                        <p>بداية أعمال المشروع في التاريخ المحدد:  {{ $offer->start_date }}</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <span class="n">3</span>
                                    <div class="header-of-box ">
                                        <h4>متابعة التقدم</h4>
                                        <p>ستتمكن من متابعة تقدم المشروع عبر لوحة التحكم في المنصة</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="box-2">
                                <div class="head-2">
                                    <span><i class="fa-solid fa-pen-to-square"></i></span>
                                    <p>إجراءات سريعة</p>
                                </div>
                                <button class="main_btn_bg">
                                    <i class="fa-solid fa-download"></i>
                                    <span>تحميل نسخة من العقد</span>
                                </button>
                                <a href="{{ route('customer.project.implementation.index' , $offer->project->id) }}" class="main_btn_bg">
                                    <i class="fa-regular fa-building"></i>
                                    <span>متابعة المشروع </span>
                                </a>
                                <a href="{{ route('customer.dashboard') }}" class="main_btn_bg">
                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span>العودة للوحة التحكم</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>







    </div>
@endsection
@push('scripts')
    <script src="/assets/js/customer/payment.js?v=2"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#deposite_payment').on('click', function(e) {
                e.preventDefault();

                const form = $("#paymentForm");
                const formData = form.serialize(); // Serialize form data

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Success:', response);
                        if (response.success == true)
                            window.location.reload();
                        // show success message or redirect
                        // alert('تم إرسال الطلب بنجاح');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        alert('حدث خطأ أثناء معالجة الدفع. الرجاء المحاولة لاحقًا.');
                    }
                });
            });

            $("#send_otp").on('click', function(e) {
                $(this).hide();
                $("#otp_input").show();
                $("#otp_sent").show();

                $("#otp_submit").show();
            });

            $('#otp_submit').on('click', function(e) {
                e.preventDefault();

                const form = $("#mobileVerify");
                const formData = form.serialize(); // Serialize form data

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success == true)
                            window.location.reload();
                        // show success message or redirect
                        // alert('تم إرسال الطلب بنجاح');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        alert('حدث خطأ أثناء معالجة الدفع. الرجاء المحاولة لاحقًا.');
                    }
                });
            });
            $('#contractSign').on('click', function(e) {
                e.preventDefault();

                // Get CSRF token
                const csrfToken = $('input[name="_token"]').val();

                // Get value from textarea
                const additionalNotes = $('#additional_notes').val();

                // Get signature value
                let signatureData = null;
                if (!signaturePad.isEmpty()) {
                    signatureData = signaturePad.toDataURL(); // صورة Base64
                } else {
                    alert("من فضلك وقّع العقد قبل الإرسال");
                    return;
                }

                let selectedServices = [];
                $('input[name="services[]"]').each(function() {
                    selectedServices.push($(this).val());
                });

                // Build request body
                const body = {
                    offer_id: "{{ $offer->id }}",
                    additional_notes: additionalNotes,
                    signature: signatureData,
                    services: selectedServices,
                    _token: csrfToken
                };

                $.ajax({
                    url: "{{ route('customer.contract.compelete.sign') }}",
                    method: 'POST',
                    data: body,
                    success: function(response) {
                        console.log('Success:', response);
                        if (response.success == true) {
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        alert('حدث خطأ أثناء معالجة التوقيع. الرجاء المحاولة لاحقًا.');
                    }
                });
            });


            // Signature pad setup
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);

            document.getElementById('clear-signature').addEventListener('click', function() {
                signaturePad.clear();
            });

            document.getElementById('mobileVerify').addEventListener('submit', function(e) {
                if (!signaturePad.isEmpty()) {
                    var dataUrl = signaturePad.toDataURL(); // صورة base64
                    document.getElementById('signature').value = dataUrl;
                } else {
                    alert("من فضلك وقّع العقد قبل الإرسال");
                    e.preventDefault();
                }
            });

        })
    </script>
@endpush
