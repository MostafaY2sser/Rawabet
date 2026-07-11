@extends('customer.layouts.main')

@section('title','العروض')

@push('styles')
    <link rel="stylesheet" href="/assets/css/customer/offes.css">
    <link rel="stylesheet" href="/assets/css/style.css">
@endpush

<style>
    header{
        padding: 12px 30px !important;
    }
</style>

@section('content')
    <div class="offers mt-4"  id="main_page">

    
        <div class="section-header">
            <div class="d-flex justify-content-between mb-3">
                <a href="{{route('customer.project.index')}}" class="text-black"> 
                    <img src="/assets/images/offers/Frame (1).png" alt=""> 
                    العودة للمشاريع
                </a>
                <div class="d-flex justify-content-between">
                    <p class="number">{{count($project->approvedOffers)}}</p>
                    <p> عرض مقدم </p>
                </div>
            </div>

            <div class="d-flex notes">
                <span class="title-section"> متاح للعروض</span>
                <span><img src="/assets/images/offers/tag-01.png" alt=""> {{ $project->category->name }}</span>
                <span><img src="/assets/images/offers/tag-01.png" alt=""> {{ $project->projectType->name }}</span>
            </div>

            <h4 class="d-inline ms-3"> {{ $project->serviceType->name }} {{ $project->buildingType->name }}</h4>
            <div class="d-flex information">
                <p> <img src="/assets/images/offers/SVG_marginj.png" alt=""> مدة الانتهاء المتوقعة : {{ $project->duration }} شهر</p>
                <p> <img src="/assets/images/offers/SVG_margin (1).png" alt=""> {{ $project->city->name }}</p>
                <p> <img src="/assets/images/offers/SVG_marginr.png" alt=""> {{ number_format($project->budget, 0, ',', '.') }} ريال</p>
                <p> <img src="/assets/images/offers/SVG_margin f.png" alt=""> المقاول: - </p>
            </div>
        </div>
    <div class="content_oofers">
            <div class="row">
                <div class=" d-flex">
                    <div class="title-of-row">
                        <i class="fa-regular fa-circle-check"></i>
                        <p>العروض المقدمة ({{ count($project->approvedOffers) }})</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3;">
                    <div class="d-flex justify-content-between">
                        <span class="number-2">{{ count($project->approvedOffers) }}</span>
                        <span>عروض </span>
                    </div>
                    <p class="star-text">انقر على "اختيار هذا العرض" للمتابعة إلى مرحلة الدفع والتعاقد</p>
                </div>

                @foreach ($project->approvedOffers as $item)
                    @include('customer.components.offer-card' ,['offer'=>$item])
                @endforeach

            </div>
        </div>

        <div class="select_offer" style="display:none;">
            <div class="text">
                <h3>
                    تم اختيار عرض:
                    <span class="selected-company">---</span>
                </h3>
                <span>
                    الضريبة:
                    <span class="selected-tax">---</span>
                    ريال
                </span>
                <span>
                    الإجمالي شامل الضريبة:
                    <span class="selected-price">---</span>
                    ريال
                </span>
            </div>
            <div class="buttons">
                <a href="#" class="main_btn_bg continue-pay">المتابعة للدفع</a>
                <button class="main_btn_bg cancel">إلغاء الاختيار</button>
            </div>
        </div>
    </div>
  <form id="offer-selection-form" method="POST" action="">
    @csrf
    <input type="hidden" name="offer_id" id="selected-offer-id">

    {{-- Container for additional service IDs --}}
    <div id="selected-services"></div>
</form>

    <script src="../../../assets/js/customer/offers.js?v={{ time() }}"></script>

@endsection

@push('scripts')

@endpush
