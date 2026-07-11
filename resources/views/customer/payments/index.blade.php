@extends('customer.layouts.main')
@section('title')
    المدفوعات
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/provider/provider.css') }}">
    <style>
        .payments .input_group { position: relative; }
        .payments .input_group button.search_icon {
            position: absolute;
            top: 50%;
            right: 7px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #9CA3AF;
            padding: 0;
            cursor: pointer;
        }
        .payments .bills table tbody tr td.actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .payments .bills table tbody tr td.actions .payment-action {
            color: #4B5563;
            font-size: 1.1rem;
            line-height: 1;
            padding: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .payments .bills table tbody tr td.actions .payment-action:hover {
            color: #F5932E;
        }
    </style>
@endpush

@section('content')
    <section class="payments" id="main_page" >
        <div class="row">

            <div class=" col-md-6 col-lg-3">
                <div class="box-1">
                    <div class="data data-1">
                        <span>إجمالي الأرباح</span>
                        <b>{{ number_format($totalProfits, 2) }}</b>
                        <p>ريال سعودي</p>
                    </div>
                    <div class="mine-box mine-box-1 ">
                        <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                </div>
            </div>

            <div class=" col-md-6 col-lg-3">
                <div class="box-1">
                    <div class="data data-2">
                        <span>مدفوعات معلقة</span>
                        <b>{{ number_format($pendingPayments, 2) }}</b>
                        <p>ريال سعودي</p>
                    </div>
                    <div class="mine-box mine-box-2"><i class="fa-solid fa-clock"></i></div>
                </div>
            </div>

            <div class=" col-md-6 col-lg-3">
                <div class="box-1">
                    <div class="data data-3">
                        <span>قيد المعالجة</span>
                        <b>{{ number_format($processingPayments, 2) }}</b>
                        <p>ريال سعودي</p>
                    </div>
                    <div class="mine-box mine-box-3 "><i class="fa-solid fa-credit-card"></i></div>
                </div>
            </div>

            <div class=" col-md-6 col-lg-3">
                <div class="box-1">
                    <div class="data data-4">
                        <span> متوسط الدفعة</span>
                       <b>{{ number_format($averagePayment, 2) }}</b>

                        <p>ريال سعودي</p>
                    </div>
                    <div class="mine-box mine-box-4"><i class="fa-solid fa-share"></i></div>
                </div>
            </div>

        </div>

        <div class="payment-management">
            <div class="payment-management-header">


                <form action="{{ route('customer.payments.index') }}" method="GET">
                    <div class="head">
                        <h4>إدارة المدفوعات</h4>
                        <div class="left">
                            <div class="input_group">
                                <input type="search" name="search" id="search" placeholder="البحث في المدفوعات..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="search_icon" aria-label="بحث">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <button type="submit" class="main_btn_bg">تصدير التقرير</button>
                        </div>
                    </div>
                     <div class="buttons">
                        <a href="{{ route('customer.payments.index') }}" class="btn">الكل({{ $totalCount }})</a>
                        <a href="{{ route('customer.payments.index', ['status' => 'pending']) }}" class="btn {{ request()->get('status') == 'pending' ? 'active' : '' }}">في
                            الانتظار({{ $pendingCount }})</a>
                        <a href="{{ route('customer.payments.index', ['status' => 'hold']) }}" class="btn {{ request()->get('status') == 'hold' ? 'active' : '' }}">قيد
                            المعالجة({{ $processingCount }})</a>
                        <a href="{{ route('customer.payments.index', ['status' => 'completed']) }}" class="btn {{ request()->get('status') == 'completed' ? 'active' : '' }}">مكتمل
                            ({{ $completedCount }})</a>
                        <a href="{{ route('customer.payments.index', ['status' => 'failed']) }}" class="btn {{ request()->get('status') == 'failed' ? 'active' : '' }}">فشل
                            ({{ $failedCount }})</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bills ">
            <div class="head">
                <div class="text">
                    <h6>الفواتير</h6>
                    <span>إدارة فواتيرك بكفاءة </span>
                </div>

            </div>

            <table>
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>المشروع </th>
                        <th>المرحلة </th>
                        <th>المبلغ </th>
                        <th>الحالة </th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->transaction_reference }}</td>
                            <td>{{ $payment->contract->offer->project->reference_number }}</td>
                            <td>{{ $payment->payementStage->title ?? '-' }}</td>
                            <td><b>{{ number_format($payment->amount, 2) }} ريال</b></td>
                           
                            <td>
                                <span @class(['atm' => in_array($payment->status, ['hold', 'processing', 'pending', 'failed'], true)])>
                                    <i class="fa-regular fa-circle-check"></i>
                                    {{ \App\Enums\PaymentStatus::getLabel($payment->status) }}
                                </span>
                            </td>
                            @include('payments.partials.table-actions', [
                                'payment' => $payment,
                                'showRoute' => 'customer.payments.show',
                                'downloadRoute' => 'customer.payments.download',
                            ])
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <div class="d-flex justify-content-center mt-4">
 @if($payments->lastPage() > 1)
<div class="d-flex justify-content-center mt-4">
    <div class="pagination mt-3 mb-5">

        {{-- Previous Page --}}
        <a href="{{ request()->fullUrlWithQuery(['page' => max(1, $payments->currentPage() - 1)]) }}"
           class="btn btn-sm btn-light @if($payments->onFirstPage()) disabled @endif">
            <i class="fa-solid fa-angle-right"></i>
        </a>

        {{-- Page Numbers --}}
        <div id="pageNumbersCustomer" class="pageNumbers">
            @for ($i = 1; $i <= $payments->lastPage(); $i++)
                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                   class="page-number btn btn-sm @if($i == $payments->currentPage()) active @endif">
                    {{ $i }}
                </a>
            @endfor
        </div>

        {{-- Next Page --}}
        <a href="{{ request()->fullUrlWithQuery(['page' => min($payments->lastPage(), $payments->currentPage() + 1)]) }}"
           class="btn btn-sm btn-light @if(!$payments->hasMorePages()) disabled @endif">
            <i class="fa-solid fa-angle-left"></i>
        </a>

    </div>
</div>
@endif

                 </div>

        </div>
    </section>
@endsection