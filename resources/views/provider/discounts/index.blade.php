@extends('provider.layouts.main')

@section('content')
    <!-- partners -->
    <div class="partners" id="main_page">
        <section class="offers">

            <div class="head">
                <h3>العروض المتاحة</h3>
                <div class="filter">
                    <div class="input_group">
                        <select name="category" id="category">
                            @foreach ($sections as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="input_group">
                        <select name="category" id="category">
                            @foreach ($partners as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach ($discounts as $item)
                    <div class="col-md-4 col-lg-3">
                        <div class="product_card">
                            <div class="image">
                                <img src="{{ Storage::url($item->image) }}" alt="اسم المنتج">
                            </div>

                            <div class="details">
                                <div class="company">
                                    <img src="{{ Storage::url($item->partner->logo) }}" alt="">
                                    <span>{{$item->partner->name}}</span>
                                </div>
                                <h5 class="title">{{ $item->name }}</h5>
                                <p class="category">القسم: {{ $item->section->name }}</p>
                                <p class="price">السعر: <span class="old-price">{{ $item->price }} ريال</span> </p>
                                <p class="discount">الخصم: {{ $item->discount }}%</p>
                                <p class="delivery">مدة التوصيل: {{ $item->shipping_time }} أيام</p>

                                <a href="#" class="main_btn_bg  contact-btn" onclick="openChat()">تواصل مع قسم
                                    المشتريات</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </section>

    </div>
@endsection
@push('scripts')
    <script src="/assets/js/customer/feedback.js"></script>
@endpush
