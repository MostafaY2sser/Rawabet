
@extends('admin.layouts.main')

@section('title')
 الخدمات الإضافية 
@endsection


@section('content')
<div class="submit_offer" id="main_page">

    <a href="{{ route('admin.offers.pending.edit' , $offer->id) }}" class="back_project">
        <i class="fa-solid fa-arrow-right"></i>
        <span>العودة </span>
    </a>

    <div class="head">
        <h6>بنود الخدمات</h6>
        <button type="button" class="add-btn main_btn_bg" onclick="addItem()">
            <span>إضافة خدمة</span>
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <form id="offerForm" method="POST" action="{{ route('admin.offers.pending.additionalServices.store', $offer->id) }}">
        @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    @csrf

    <div id="itemsContainer">
        @foreach ($offer->additionalServices as $key=>$item)
        <div class="item_box item" id="paymentItem{{ $key + 1 }}">
            <h6 class="item-title">الخدمة {{ $key + 1 }}</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="input_group">
                        <label>عنوان الخدمة</label>
                        <input type="text" name="items[{{ $key }}][title]"
                        value="{{ $item->title }}"
                               oninput="syncInpust('paymentItemTitle${itemIndex + 1}', this)"
                               placeholder="كمثال أعمال الحفر والأساسات" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input_group">
                        <label>الوصف</label>
                        <input type="text" name="items[{{ $key }}][description]"
                          value="{{ $item->description }}"
                               oninput="syncInpust('paymentItemDescription${itemIndex + 1}', this)"
                               placeholder="وصف الخدمة..." required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 col-lg-3">
                    <div class="input_group">
                        <label>تاريخ البداية</label>
                        <input type="date" name="items[{{ $key }}][start_date]"
       value="{{ \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') }}"
       required>

                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="input_group">
                        <label>تاريخ النهاية</label>
                        <input type="date" name="items[{{ $key }}][end_date]" value="{{ $item->end_date }}"  required>
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="input_group">
                        <label>قيمة الدفعة</label>
                        <input type="number" name="items[{{ $key }}][amount]"
                               oninput="handlePaymentInput(this, ${itemIndex + 1});"
                                value="{{ $item->amount }}"
                               placeholder="0" required>

                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4">
                    <div class="input_group">
                        <label>مدة التنفيذ</label>
                        <input type="number" name="items[{{ $key }}][duration]"  value="{{ $item->total_days }}" placeholder="0" readonly required>
                    </div>
                </div>
                
            </div>
            <div class="input_group">
                <label>المواصفات</label>
                <textarea name="items[{{ $key }}][specifications]" placeholder="المواصفات الفنية والمتطلبات...">{{$item->specifications}}</textarea>
            </div>
            <button type="button" class="remove-btn" onclick="removeItem(this ,'{{ $key + 1 }}')">
                <i class="fa-regular fa-trash-can"></i>
            </button>
        </div>
        @endforeach

    </div>


    <div class="buttons">
        @can('create offers.additionalServices')
        <button type="submit" class="submit-btn main_btn_bg" name="action" value="submit">إرسال </button>
            
        @endcan
        {{-- <button type="submit" class="main_btn_bg save" name="action" value="draft">حفظ كمسودة</button> --}}
        <button type="button" class="main_btn_bg cancel" onclick="window.location.href='{{ route('admin.offers.pending.index') }}'">إلغاء</button>
    </div>
</form>

</div>
@endsection

@push('scripts')
<script>
    window.projectStartDate = "{{ $project->start_date ?? '' }}";
    let itemIndex = {{ count($offer->additionalServices) }} 
</script>

<script src="{{ asset('assets/js/admin/submit-offer.js') }}"></script>
@if (count($offer->additionalServices)  == 0)
<script>
    document.addEventListener('DOMContentLoaded', () => {
    addItem();
    })
</script>
    
@endif
@endpush


