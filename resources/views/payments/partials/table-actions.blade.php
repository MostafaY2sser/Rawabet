@props(['payment', 'showRoute', 'downloadRoute'])

<td class="actions">
    <a href="{{ route($showRoute, $payment->id) }}" class="payment-action" title="عرض الفاتورة">
        <i class="fa-regular fa-eye"></i>
    </a>
    <a href="{{ route($downloadRoute, $payment->id) }}" class="payment-action" title="تحميل الفاتورة">
        <i class="fa-solid fa-download"></i>
    </a>
</td>
