
@extends('provider.layouts.main')

@section('title')
تقديم عرض سعر
@endsection


@section('content')
<div class="submit_offer" id="main_page">

    <a href="{{ route('provider.project.show' , $project->id) }}" class="back_project">
        <i class="fa-solid fa-arrow-right"></i>
        <span>العودة للمشروع</span>
    </a>

    <div class="head">
        <h6>بنود المشروع</h6>
        <button type="button" class="add-btn main_btn_bg" onclick="addItem()">
            <span>إضافة بند</span>
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>

    <form id="offerForm" action="{{ route('provider.offers.store', $project->id) }}" method="POST">
        @csrf

        
    
        <div id="itemsContainer"></div>
            <div class="time_tabel mt-5">
            <h5>الجدول الزمني للمشروع</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="input_group">
                        <label for="projectStart">تاريخ بدء المشروع</label>
                        <input type="date" name="projectStart" id="projectStart" 
                               value="{{ $project->start_date }}" 
                               min="{{ $project->start_date }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input_group">
                        <label for="duration">المدة (بالأيام)</label>
                        <input type="text" name="duration" id="duration" placeholder="0" readonly required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input_group">
                        <label for="expectedFinish">تاريخ الإنجاز المتوقع</label>
                        <input type="text" name="expectedFinish" id="expectedFinish" placeholder="yyyy-mm-dd" readonly required>
                    </div>
                </div>
            </div>
        </div>


        <div class="payment_schedule" id="payment_schedule"></div>

        <div class="box total">
            <span>إجمالي قيمة المشروع</span>
            <span id="projectTotal">ريال 0</span>
        </div>

        <div class="buttons">
            <button type="submit" class="submit-btn main_btn_bg" name="action" value="submit">إرسال العرض</button>
            {{-- <button type="submit" class="main_btn_bg save" name="action" value="draft">حفظ كمسودة</button> --}}
            <button type="button" class="main_btn_bg cancel" onclick="window.location.href='{{ route('provider.project.show' , $project->id) }}'">إلغاء</button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
    window.projectStartDate = "{{ $project->start_date }}"; 
</script>
<script src="{{ asset('assets/js/provider/submit-offer.js') }}"></script>

@endpush

