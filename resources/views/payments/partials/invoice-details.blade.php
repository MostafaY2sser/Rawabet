@php
    $project = $payment->contract?->offer?->project;
    $invoiceNumber = $payment->transaction_reference ?: 'INV-' . str_pad($payment->id, 3, '0', STR_PAD_LEFT);
@endphp

<div class="payment-invoice-details">
    <div class="row mb-3">
        <div class="col-md-6">
            <p class="mb-1 text-muted">رقم الفاتورة</p>
            <strong>{{ $invoiceNumber }}</strong>
        </div>
        <div class="col-md-6">
            <p class="mb-1 text-muted">تاريخ المعاملة</p>
            <strong>{{ $payment->created_at?->format('Y-m-d') ?? '—' }}</strong>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <p class="mb-1 text-muted">المشروع</p>
            <strong>{{ $project?->reference_number ?? '—' }}</strong>
        </div>
        <div class="col-md-6">
            <p class="mb-1 text-muted">المرحلة</p>
            <strong>{{ $payment->payementStage?->title ?? '—' }}</strong>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <p class="mb-1 text-muted">المبلغ</p>
            <strong>{{ number_format($payment->amount, 2) }} ريال</strong>
        </div>
        <div class="col-md-6">
            <p class="mb-1 text-muted">الحالة</p>
            <strong>{{ \App\Enums\PaymentStatus::getLabel($payment->status) }}</strong>
        </div>
    </div>
    @if ($payment->contract?->reference)
        <div class="row">
            <div class="col-md-6">
                <p class="mb-1 text-muted">مرجع العقد</p>
                <strong>{{ $payment->contract->reference }}</strong>
            </div>
        </div>
    @endif
</div>
