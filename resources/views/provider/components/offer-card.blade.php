@php
    $statusClass = \App\Enums\OfferStatus::getClass($offer->status);
    $statusLabel = \App\Enums\OfferStatus::getLabel($offer->status);
    $statusIcon = \App\Enums\OfferStatus::getIcon($offer->status);
    $statusShort = \App\Enums\OfferStatus::shortStatus($offer->status);


@endphp

<div class="project {{ $statusClass }}">
    <div class="status {{ $statusClass }}">
        <i class="{{ $statusIcon }}"></i>
        <span>{{ $statusShort }}</span>
    </div>


    <h3 class="project_name">
        {{ $offer->project?->buildingType?->name }}
    </h3>

    <div class="order_number">
        <p>رقم العرض: </p>
        <span>#{{ $offer->id }}</span>
    </div>

    <div class="info">
        <div class="line">
            <div>
                <p>قيمة العرض</p>
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <span dir="rtl">{{ number_format($offer->total_amount) }} ريال</span>
        </div>
        <div class="line">
            <div>
                <p>مدة التنفيذ</p>
                <i class="fa-regular fa-calendar"></i>
            </div>
<span dir="rtls">
   {{ $offer->total_days }} يوم
</span>
        </div>
        <div class="line">
            <div>
                <p>تاريخ التقديم</p>
                <i class="fa-regular fa-clock"></i>
            </div>
            <span
                dir="rtl">{{ \Carbon\Carbon::parse($offer->created_at)->locale('ar')->translatedFormat('j F Y') }}</span>
        </div>
    </div>

    <p class="response_status">
        {{ $statusLabel }}
    </p>

    <div class="buttons">
        @if($offer->status === \App\Enums\OfferStatus::REQUIRE_UPDATE->value)
            <a href="" class="main_btn_bg update">تعديل</a>
        @endif
        <a href="{{ route('provider.offers.show', $offer->id) }}" class="main_btn_bg">عرض التفاصيل</a>
    </div>
</div>