@extends('provider.layouts.main')
@section('title', 'تفاصيل الفاتورة')

@section('content')
    <section class="payments" id="main_page">
        <div class="bills">
            <div class="head d-flex justify-content-between align-items-center mb-4">
                <div class="text">
                    <h6>تفاصيل الفاتورة</h6>
                    <span>عرض بيانات الدفعة</span>
                </div>
                <a href="{{ route('provider.payments.index') }}" class="main_btn_bg">
                    <i class="fa-solid fa-arrow-right ms-1"></i>
                    العودة للمدفوعات
                </a>
            </div>

            <div class="card_content p-4">
                @include('payments.partials.invoice-details', ['payment' => $payment])
            </div>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('provider.payments.download', $payment->id) }}" class="main_btn_bg">
                    <i class="fa-solid fa-download"></i>
                    تحميل الفاتورة
                </a>
            </div>
        </div>
    </section>
@endsection
