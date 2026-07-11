@extends('admin.layouts.main')
@section('title', 'تفاصيل المعاينة')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
@section('content')
    <div class="project_details provider inspection_manage"  id="main_page">

        <div class="project_info">
            <div class="head">
                <a href="{{ route('admin.inspection.index') }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_2116_5648)">
                            <path d="M4.16797 10H15.8346" stroke="#4B5563" stroke-width="1.66667" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M10 4.16797L15.8333 10.0013L10 15.8346" stroke="#4B5563" stroke-width="1.66667"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_2116_5648">
                                <rect width="20" height="20" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    <span>العودة للمشاريع</span>
                </a>
            </div>

            <h2 class="project_name">
                {{ $inspection->project->ServiceType->name . $inspection->project->buildingType->name }}</h2>

            <div class="info">
                <div>
                    <span>{{ \Carbon\Carbon::parse($inspection->project->start_date)->addMonths($inspection->project->duration)->locale('ar')->translatedFormat('l j F Y') }}</span>
                    <p>مدة الانتهاء المتوقعة:</p>
                    <img src="/assets/images/customer/icons/culander.png" alt="">
                </div>
                <div>
                    <span>{{ $inspection->project->city->name }}</span>
                    <img src="/assets/images/customer/icons/location.png" alt="">
                </div>
                <div>
                    <p>ريال</p>
                    <span>{{ $inspection->project->budget }}</span>
                    <img src="/assets/images/customer/icons/budget.png" alt="">
                </div>
            </div>
        </div>




        <div class="about_project">
            <div class="contents">

                <div class="inspection_info">
                    <div class="date_time">
                        <h6>تاريخ و وقت المعاينة</h6>
                        <div class="d-flex align-items-center gap-5">
                            <span>{{ \Carbon\Carbon::parse($inspection->date)->format('d/m/Y') }}</span>
                            <span>{{ $inspection->time }}</span>
                        </div>
                    </div>
                    <div class="consultant">
                        <h6>الاستشاري المعين</h6>
                        <span>{{ $inspection->project->consultant->fullname }}</span>
                    </div>
                    @if ($inspection->reschedule_request)
                        <div class="request_date">
                            <h6>بيانات الطلب</h6>
                            <div class="d-flex align-items-center gap-5">
                                <span>{{ \Carbon\Carbon::parse($inspection->requested_date)->format('d/m/Y') }}</span>
                                <span>{{ $inspection->requested_time }}</span>
                            </div>

                        </div>
                    @endif

                </div>


                <button class="main_btn_bg" id="editInspectionBtn">تعديل</button>


                <div class="request_inspection " id="request_inspection">
                    <div class="wrapper ">
                        <h6>تعديل موعد المعاينة</h6>
                        <form action="{{ route('admin.inspection.update', $inspection->id) }}"method="POST">
                            @method('PUT')

                            @csrf
                            <div class="new_date">
                                <label for="inlineCalendar">اختر التاريخ </label>
                                    <input type="text" value="{{ \Carbon\Carbon::parse($inspection->date)->format('d/m/Y') }}" name="date" id="inlineCalendar" hidden>
                            </div>
                            <div class="input_group">
                                <label for="time">اختر الوقت</label>
                                <input type="time" value="{{ $inspection->time }}" name="time" id="time">
                            </div>

                            <div class="my-3">
                                <label for="notes">اختيار الاستشاري</label>
                                <select class="form-control" name="consultant_id" id="consultant_id">
                                    <option value="">اختر استشاري</option>
                                    @foreach ($consultants as $item)
                                        <option @selected($item->id == $inspection->project->consultant_id) value="{{ $item->id }}">
                                            {{ $item->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="buttons">
                                <button class="main_btn_bg">تأكيد </button>
                                <!-- <button class="main_btn_bg cancel">إلغاء</button> -->
                                <button class="main_btn_bg" id="requestChangeBtn">موعد طلب التغيير</button>
                            </div>
                        </form>
                        <div class="close_request_inspection">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4L4 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M4 4L12 12" stroke="#020817" stroke-width="1.33333" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                </div>


            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script src="/assets/js/admin/inspection.js"></script>
@endpush
