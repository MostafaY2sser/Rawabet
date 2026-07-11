@php
        $additionalServicesCost = $offer->additionalServices()->sum('amount');
        $baseTotal = $offer->total_amount;
        $taxRate = (float) getsetting('tax_percentage');
        $taxAmount = getTaxAmount($baseTotal);
      
        $totalWithTax = $baseTotal + $taxAmount;
@endphp

<style>
    .sec-1.active {
        background: #f5932e38
    }
</style>
<div class="col-md-6 col-lg-4">
    {{-- <div class="sec-1  mt-3"> --}}
    <div class="sec-1 mt-3 offer-card" data-offer-card="{{ $offer->id }}" data-tax-rate="{{ $taxRate }}">
        <h4>{{ $offer->provider->company_name }}</h4>
        <div class="comment d-flex justify-content-center">
            <div class="star">
                {{ number_format($offer->provider->ratingsQuery()->avg('contractor_rating'), 1) }}
                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8.80339 1.33203L10.8634 5.50536L15.4701 6.1787L12.1367 9.42537L12.9234 14.012L8.80339 11.8454L4.68339 14.012L5.47005 9.42537L2.13672 6.1787L6.74339 5.50536L8.80339 1.33203Z"
                        fill="#FACC15" stroke="#FACC15" stroke-width="1.33333"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="rate">({{ $offer->provider->ratingsQuery()->count() }} تقييم)</div>
        </div>

        <div class="box d-flex justify-content-center">
            <div class="mosths">
<span>
  {{ $offer->total_days }} يوم
</span>
                <p>مدة التنفيذ</p>
            </div>
            <div class="money">
                <span class="offer-subtotal">{{ number_format($baseTotal, 0, ',', '.') }} ريال</span>
                <p>التكلفة الإجمالية</p>
            </div>
        </div>

        <div class="offer-tax-summary">
            <p>
                الضريبة:
                <span class="offer-tax">{{ number_format($taxAmount, 0, ',', '.') }}</span>
                ريال
            </p>
            <p>
                الإجمالي شامل الضريبة:
                <span class="offer-total-with-tax">{{ number_format($totalWithTax, 0, ',', '.') }}</span>
                ريال
            </p>
        </div>

        <div class="card-z d-flex">
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.1991 11.3438L14.4616 18.4487C14.4757 18.5324 14.464 18.6184 14.4279 18.6952C14.3919 18.772 14.3332 18.836 14.2598 18.8786C14.1864 18.9212 14.1018 18.9403 14.0172 18.9335C13.9326 18.9267 13.8522 18.8942 13.7865 18.8404L10.8032 16.6012C10.6592 16.4937 10.4842 16.4355 10.3045 16.4355C10.1247 16.4355 9.94974 16.4937 9.80572 16.6012L6.81738 18.8396C6.75182 18.8933 6.67144 18.9257 6.58696 18.9325C6.50249 18.9394 6.41794 18.9203 6.3446 18.8778C6.27126 18.8353 6.21261 18.7715 6.17648 18.6949C6.14035 18.6182 6.12846 18.5323 6.14238 18.4487L7.40405 11.3438" stroke="#2563EB" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.3008 12.2695C13.0622 12.2695 15.3008 10.031 15.3008 7.26953C15.3008 4.50811 13.0622 2.26953 10.3008 2.26953C7.53936 2.26953 5.30078 4.50811 5.30078 7.26953C5.30078 10.031 7.53936 12.2695 10.3008 12.2695Z" stroke="#2563EB" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <p>{{ $offer->provider->completedProjectsCount() }} مشروع مكتمل</p>
        </div>

        <div class="card-x d-flex">
            <i class="fa-regular fa-file-lines"></i>
            <p>رخصة رقم: {{ $offer->provider->commercial_registration }}</p>
        </div>

        <div class="card-y d-flex">
            <i class="fa-regular fa-calendar"></i>
            <p>البدء: {{ $offer->start_date }}</p>
        </div>

        <div class="sec-2">
            <div class="title d-flex align-items-center gap-2">
                <i class="fa-regular fa-clock"></i>
                <h4>مراحل التنفيذ</h4>
            </div>
            <div class="scroll">
                @foreach ($offer->items as $item)
                    <div class="d-flex justify-content-between data">
                        <div class="diat">
                            <b class="budget">{{ number_format($item->amount, 0, ',', '.') }} ر.س</b>
                            <div class="week">
                                <span>ايام</span>
                                
                                <span>{{ $item->total_days }}</span>
                            </div>
                        </div>
                        <p>{{ $item->title }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ---------------------------------------------------------------------- --}}
            <div class="sec-3">

                <div class="services">
                   @foreach ($offer->additionalServices as $item)
   <div class="services additional-services" data-offer-id="{{ $offer->id }}" style="display: none;">
    <div class="title d-flex ">

    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
    xmlns="http://www.w3.org/2000/svg">
    <path d="M10.3008 2.26953V18.9362" stroke="#16A34A" stroke-width="1.66667"
        stroke-linecap="round" stroke-linejoin="round" />
    <path
        d="M14.4674 4.76953H8.21745C7.4439 4.76953 6.70203 5.07682 6.15505 5.6238C5.60807 6.17078 5.30078 6.91265 5.30078 7.6862C5.30078 8.45975 5.60807 9.20161 6.15505 9.74859C6.70203 10.2956 7.4439 10.6029 8.21745 10.6029H12.3841C13.1577 10.6029 13.8995 10.9102 14.4465 11.4571C14.9935 12.0041 15.3008 12.746 15.3008 13.5195C15.3008 14.2931 14.9935 15.0349 14.4465 15.5819C13.8995 16.1289 13.1577 16.4362 12.3841 16.4362H5.30078"
        stroke="#16A34A" stroke-width="1.66667" stroke-linecap="round"
        stroke-linejoin="round" />
</svg>  <h4>الخدمات الإضافية</h4>

</div>
    @foreach ($offer->additionalServices as $item)
        <div class="d-flex justify-content-between">
            <input type="checkbox" class="custom-checkbox"
                name="additional_services"
                value="{{ $item->id }}"
                data-offer-id="{{ $offer->id }}" />
            <span class="checkmark"></span>
            <p>{{ $item->title }}</p>
            <b>{{ number_format($item->amount, 0, ',', '.') }} ر.س</b>
        </div>
    @endforeach
</div>

@endforeach

                  

                  

                </div>
            </div>
            {{-- ---------------------------------------------------------------------- --}}

        </div>

        @php
            $contract = $offer->contract;
            $isSigningInProgress = $contract && $contract->deposit_paid && !$contract->signtured;
        @endphp

        {{-- زرار اختيار العرض --}}
        <button 
            type="button"
            class="choose d-flex justify-content-center w-100 choose-offer-btn"
            data-id="{{ $offer->id }}"
            data-company="{{ $offer->provider->company_name }}"
            data-price="{{ number_format($offer->total_amount, 0, ',', '.') }}"
            data-price-raw="{{ $offer->total_amount }}"
            data-sign-url="{{ route('customer.contract.sign', $offer->id) }}"
            data-signing-in-progress="{{ $isSigningInProgress ? '1' : '0' }}"
        >
            <i class="fa-regular fa-circle-check"></i>
            <p>{{ $isSigningInProgress ? 'استكمال التوقيع' : 'اختيار هذا العرض' }}</p>
        </button>

        <div class="profile d-flex justify-content-center">
            <i class="fa-regular fa-eye"></i>
            <a href="{{ route('providers.show' , $offer->provider->id) }}">عرض الملف التعريفي</a>
        </div>
    </div>
</div>
